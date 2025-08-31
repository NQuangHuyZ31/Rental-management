<?php

/*
    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Handle login and register
*/
namespace App\Controllers;

use Core\ViewRender;
use App\Models\Role;
use App\Requests\LoginValidate;
use Core\CSRF;
use Core\Request;
use Core\Session;
use Helpers\Log;

class AuthController extends Controller {
    protected $role;
    protected $request;

    public function __construct() {
        parent::__construct();
        $this->role = new Role();
        $this->request = new Request();
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

        if (Session::has('user') && Session::get('user')['role'] == $role) { 
            Log::write(json_encode(['redirect' => $redirect, 'message' => 'success', 'user_id' => Session::get('user')['id']]), Log::LEVEL_ERROR);
            $this->request->redirect($redirect);
            exit;
        }
    }

    public function showRegisterPage() {
        $roles = $this->role->getAllRoles();

        ViewRender::render('register',
            [
                'roles' => $roles
            ]
        );
    }

    public function handleRegister() {}

    public function logout() {
        $this->auth->logout();
        $this->request->redirect('/');
    }
}