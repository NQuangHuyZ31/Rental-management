<?php

/*
    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Handle login and register
*/
namespace App\Controllers;

use Core\ViewRender;
use App\Models\Role;
use App\Models\User;
use App\Requests\LoginValidate;
use App\Requests\RegisterValidate;
use Core\CSRF;
use Core\Request;
use Core\Session;
use App\Models\OTPVerify;
use App\Requests\VerifyOtpValidate;
use Core\Response;
use Helpers\Hash;
use Queue\SendEmailOTPJob;
use Helpers\Log;
use Stringable;

class AuthController extends Controller {
    protected $role;
    protected $request;
    protected $user;
    protected $otp;
    protected $sendEmailOTPJob;
    
    public function __construct() {
        parent::__construct();
        $this->role = new Role();
        $this->request = new Request();
        $this->user = new User();
        $this->otp = new OTPVerify();
        $this->sendEmailOTPJob = new SendEmailOTPJob();
    }

    public function showLoginPage() {
        ViewRender::render('login',['request' => $this->request]);
    }

    public function handleLogin() {
        $request = $this->request->post();
        $role = $request['selected_role'] == 'customer' ? '3' : '2';
        $redirect = $role == '3' ? '/' : '/landlord';
        $errors = LoginValidate::validate($request) ?? [];

        if (!empty($errors)) {
            $this->request->redirectWithErrors('/login', $errors);
            exit;
        }

        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            $this->request->redirectWithErrors('/login', 'Lỗi xảy ra. Vui lòng thử lại');
            exit;
        }

        if (!$this->auth->login($request['email'], $request['password'], $role)) {
            $this->request->redirectWithErrors('/login', 'Email hoặc mật khẩu không đúng');
            exit;
        }

        // Check if user session exists and role matches
        if (Session::has('user') && Session::get('user')['role'] == $role) { 
            // Update last login time only if user session exists
            $this->user->updateColumn(Session::get('user')['id'], 'last_login', date('Y-m-d H:i:s'));
            
            Log::write(json_encode(['redirect' => $redirect, 'message' => 'success', 'user_id' => Session::get('user')['id']]), Log::LEVEL_ERROR);
            $this->request->redirect($redirect);
            exit;
        }
    }

    public function showRegisterPage() {
        $roles = $this->role->getAllRoles();

        ViewRender::render('register',
            [
                'roles' => $roles,
                'request' => $this->request
            ]
        );
    }

    public function handleRegister() {
        $request = $this->request->post();

        $errors = RegisterValidate::validate($request);

        if (!empty($errors)) {
            $this->request->redirectWithErrors('/register', $errors);
            exit;
        }

        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            $this->request->redirectWithErrors('/register', 'Lỗi xảy ra. Vui lòng thử lại');
            exit;
        }
        
        // Xóa user nếu email tồn tại và chưa active
        $user = $this->user->getUserByEmail($request['email'], 'inactive');
        if ($user) {
            $this->user->deleteUser($user['id']);
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
            exit;
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
            exit;
        }

        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            $this->request->redirectWithError('/verify-account', 'Lỗi xảy ra. Vui lòng thử lại');
            exit;
        }

        $user = $this->user->getUserByEmail(Session::get('email'), 'inactive');
        $otp = $this->otp->getOTPByUserId($user['id']);

        if (!Hash::verify($otpRequest, $otp['otp_code'])) {
            $this->request->redirectWithError('/verify-account', 'Mã OTP không đúng. Vui lòng thử lại');
            exit;
        }

        if ($otp && $otp['expired'] < time()) {
            $this->request->redirectWithError('/verify-account', 'Mã OTP đã hết hạn. Vui lòng gửi lại mã OTP.');
            exit;
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
        Session::set('verify',true);
        return true;
    }

    public function handleResendOTP() {
        if (!CSRF::validatePostRequest()) {
            CSRF::refreshToken();
            Response::json([
                'error' => [
                    'msg' => 'Lỗi xảy ra. Vui lòng thử lại'
                ],
                'token' => CSRF::getToken()
            ], 400);
            exit;
        }
        
        $user = $this->user->getUserByEmail(Session::get('email'), 'inactive');
        
        if ($this->sendOTP($user['id'], Session::get('email'), $user['username'])) {
            Response::json([
                'success' => [
                    'msg' => 'Mã OTP đã được gửi lại. Vui lòng kiểm tra email.'
                ],
                'token' => CSRF::getToken()
            ], 200);
            exit;
        }
    }

    public function logout() {
        $this->auth->logout();
        $this->request->redirect('/');
    }
}