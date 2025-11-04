<?php

/*
Author: Huy Nguyen
Date: 2025-08-31
Purpose: Handle login and register
 */
namespace App\Controllers;

use App\Models\OTPVerify;
use App\Models\Role;
use App\Models\User;
use App\Requests\LoginValidate;
use App\Requests\PasswordValidate;
use App\Requests\RegisterValidate;
use App\Requests\VerifyOtpValidate;
use Core\CSRF;
use Core\Request;
use Core\Response;
use Core\Session;
use Core\ViewRender;
use Helpers\Hash;
use Queue\SendEmailOTPJob;
use Queue\SendEmailResetPassword;

class AuthController extends Controller {
    protected $role;
    protected $request;
    protected $user;
    protected $otp;
    protected $sendEmailOTPJob;
    protected $sendEmailResetPasswordJob;

    public function __construct() {
        parent::__construct();
        $this->role = new Role();
        $this->request = new Request();
        $this->user = new User();
        $this->otp = new OTPVerify();
        $this->sendEmailOTPJob = new SendEmailOTPJob();
        $this->sendEmailResetPasswordJob = new SendEmailResetPassword();
    }

    public function showLoginPage() {
        ViewRender::render('login', ['request' => $this->request]);
    }

    public function handleLogin() {
        $request = $this->request->post();
        $role = $request['selected_role'] == 'customer' ? '3' : '2';
        $redirect = $role == '3' ? '/' : '/landlord';
        $errors = LoginValidate::validate($request) ?? [];

        if (!empty($errors)) {
            $this->request->redirectWithErrors('/login', $errors);
        }

        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            $this->request->redirectWithErrors('/login', 'Lỗi xảy ra. Vui lòng thử lại');
        }

        if (!$this->auth->login($request['email'], $request['password'], $role)) {
            $this->request->redirectWithErrors('/login', 'Email hoặc mật khẩu không đúng');
        }

        $user = $this->user->getUserById(Session::get('user')['id']);

        if ($user && $user['account_status'] == 'banned') {
            Session::delete('user');
            $this->request->redirectWithErrors('/login', 'Tài khoản của bạn đã bị cấm. Vui lòng liên hệ hosty để được hỗ trợ');
        }

        // Check if user session exists and role matches
        if (Session::has('user') && Session::get('user')['role'] == $role) {
            // Update last login time only if user session exists
            $this->user->updateColumn(Session::get('user')['id'], 'last_login', date('Y-m-d H:i:s'));
            $this->request->redirect($redirect);
        }
    }

    public function showRegisterPage() {
        $roles = $this->role->getAllRoles();

        ViewRender::render('register',
            [
                'roles' => $roles,
                'request' => $this->request,
            ]
        );
    }

    public function handleRegister() {
        $request = $this->request->post();

        $errors = RegisterValidate::validate($request);

        if (!empty($errors)) {
            $this->request->redirectWithErrors('/register', $errors);
        }

        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            $this->request->redirectWithErrors('/register', 'Lỗi xảy ra. Vui lòng thử lại');
        }

        // Xóa user nếu email tồn tại và chưa active
        $user = $this->user->getUserByEmail($request['email'], 'inactive');
        if ($user) {
            $this->user->updateColumn($user['id'], 'deleted', '1');
        }

        // Lưu thông tin đăng ký
        $userData = [
            'username' => $request['username'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
            'role_id' => $request['role'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $userID = $this->user->insertUser($userData);

        if ($this->sendOTP($userID, $request['email'], $request['username'])) {
            $this->request->redirect('/verify-account', [
                'email' => $request['email'] ?? 'abc@gmail.com',
            ]);
        }

        $this->request->redirectWithErrors('/register', 'Lỗi xảy ra. Vui lòng thử lại');
    }

    public function verifyAccount() {
        ViewRender::render('verify-otp', ['request' => $this->request, 'email' => Session::get('email') ?? 'abc@gmail.com']);
    }

    public function handleVerifyAccount() {
        $otpRequest = $this->request->post('otp');
        $errors = VerifyOtpValidate::validate($otpRequest);

        if (!empty($errors)) {
            $this->request->redirectWithError('/verify-account', $errors);
        }

        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            $this->request->redirectWithError('/verify-account', 'Lỗi xảy ra. Vui lòng thử lại');
        }

        $user = $this->user->getUserByEmail(Session::get('email'), 'inactive');
        $otp = $this->otp->getOTPByUserId($user['id']);

        if (!Hash::verify($otpRequest, $otp['otp_code'])) {
            $this->request->redirectWithError('/verify-account', 'Mã OTP không đúng. Vui lòng thử lại');
        }

        if ($otp && $otp['expired'] < time()) {
            $this->request->redirectWithError('/verify-account', 'Mã OTP đã hết hạn. Vui lòng gửi lại mã OTP.');
        }

        $this->user->updateColumn($user['id'], 'account_status', 'active');
        $this->user->updateColumn($user['id'], 'updated_at', date('Y-m-d H:i:s'));
        $this->user->updateColumn($user['id'], 'email_verified_at', date('Y-m-d H:i:s'));
        $this->otp->updateColumn($otp['id'], 'is_verified', '1');
        $this->otp->updateColumn($otp['id'], 'updated_at', date('Y-m-d H:i:s'));

        // Xóa session
        Session::delete('email');
        Session::delete('verify');

        // Chuyển hướng đến trang login
        $this->request->redirectWithSuccess('/login', 'Xác thực thành công. Vui lòng đăng nhập lại.');
        exit;
    }

    public function sendOTP($userID, $email, $customer) {
        $otp = rand(100000, 999999);
        $hashedOtp = Hash::encrypt($otp);
        $this->otp->insertOTP([
            'user_id' => $userID,
            'otp_code' => $hashedOtp,
            'expired' => time() + 3600,
            'type' => 'register',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->sendEmailOTPJob->dispatchHigh([
            'to' => $email,
            'customer' => $customer,
            'otpCode' => $hashedOtp,
            'purpose' => 'Xác minh tài khoản',
        ]);
        Session::set('email', $email);
        Session::set('verify', true);
        return true;
    }

    public function handleResendOTP() {
        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            Response::json([
                'error' => [
                    'msg' => 'Lỗi xảy ra. Vui lòng thử lại',
                ],
                'token' => CSRF::getToken(),
            ], 400);
        }

        $user = $this->user->getUserByEmail(Session::get('email'), 'inactive');

        if ($this->sendOTP($user['id'], Session::get('email'), $user['username'])) {
            Response::json([
                'success' => [
                    'msg' => 'Mã OTP đã được gửi lại. Vui lòng kiểm tra email.',
                ],
                'token' => CSRF::getToken(),
            ], 200);
        }
    }

    // =============================== FORGOT PASSWORD ======================================

    // show forgot password page
    public function showForgotPasswordPage() {
        ViewRender::render('forgot-password', ['request' => $this->request]);
    }

    // Send link reset password
    public function sendLinkResetPassword() {
        $data = $this->request->post();

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (empty($data['email'])) {
            Response::json(['status' => 'error', 'msg' => 'Vui lòng nhập email', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $data['email'])) {
            Response::json(['status' => 'error', 'msg' => 'Email không hợp lệ', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $user = $this->user->getUserByEmail($data['email']);
        if (!$user) {
            Response::json(['status' => 'error', 'msg' => 'Email không tồn tại trong hệ thống', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $dataUser = ['email' => $user['email'], 'username' => $user['username'], 'time' => time()];

        $dataEncrypted = Hash::encrypt(json_encode($dataUser));
        $dataResetPassword = [
            'user_id' => $user['id'],
            'otp_code' => $dataEncrypted,
            'expired' => time() + 300,
            'type' => 'forgot_password',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->otp->insertOTP($dataResetPassword);

        $resetUrl = APP_URL . '/reset-password?token=' . $dataEncrypted;
        $this->sendEmailResetPasswordJob->dispatchHigh([
            'to' => $user['email'],
            'customer' => $user['username'],
            'resetUrl' => $resetUrl,
        ]);

        Response::json(['status' => 'success', 'msg' => 'Link đặt lại mật khẩu đã được gửi đến email của bạn', 'token' => CSRF::getTokenRefresh()], 200);
        exit;
    }

    public function showResetPasswordPage() {
        $token = $this->request->get('token');
        $token = str_replace(' ', '+', $token);

        if (empty($token)) {
            $this->request->redirectWithError('/forgot-password', 'Token không hợp lệ');
            return;
        }

        ViewRender::render('reset-password', ['request' => $this->request, 'token' => $token]);
    }

    // Handle reset password
    public function handleResetPassword() {
        $request = $this->request->post();

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (empty($request['token'])) {
            Response::json(['status' => 'error', 'msg' => 'Token không hợp lệ', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $errors = PasswordValidate::validate($request);

        if (!empty($errors)) {
            Response::json(['status' => 'error', 'msg' => $errors, 'token' => CSRF::getTokenRefresh()], 400);
        }

        $data = Hash::decrypt($request['token']);
        $data = json_decode($data, true);
        $user = $request['verify_account'] == 1 ? $this->user->getUserByEmail($data['email'], 'inactive') : $this->user->getUserByEmail($data['email']);

        if (!$user) {
            Response::json(['status' => 'error', 'msg' => 'Tài khoản không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if ($request['verify_account'] != 1) {
            $otp = $this->otp->getOTPByUserIdAndType($user['id'], 'forgot_password');

            if ($request['token'] !== $otp['otp_code']) {
                Response::json(['status' => 'error', 'msg' => 'Token không hợp lệ', 'token' => CSRF::getTokenRefresh()], 400);
            }

            if ($otp['expired'] < time()) {
                Response::json(['status' => 'error', 'msg' => 'Token đã hết hạn', 'token' => CSRF::getTokenRefresh()], 400);
            }

            $this->otp->updateColumn($otp['id'], 'is_verified', '1');
            $this->otp->updateColumn($otp['id'], 'updated_at', date('Y-m-d H:i:s'));
        } else {
            $this->user->updateColumn($user['id'], 'account_status', 'active');
        }

        $hashed = password_hash($request['password'], PASSWORD_DEFAULT);
        $this->user->updateColumn($user['id'], 'password', $hashed);
        $this->user->updateColumn($user['id'], 'updated_at', date('Y-m-d H:i:s'));
        $this->user->updateColumn($user['id'], 'email_verified_at', date('Y-m-d H:i:s'));

        Response::json(['status' => 'success', 'msg' => $request['verify_account'] != 1 ? 'Đặt lại mật khẩu thành công' : 'Kích hoạt tài khoản thành công', 'token' => CSRF::getTokenRefresh()], 200);
    }

    public function logout() {
        $this->auth->logout();
        $this->request->redirect('/');
    }
}