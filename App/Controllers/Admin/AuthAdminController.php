<?php

/*
    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Handle login for admin
*/

namespace App\Controllers\Admin;

use App\Controllers\AuthController;
use App\Models\User;
use App\Requests\LoginValidate;
use Core\CSRF;
use Core\ViewRender;
use Core\Request;
use Core\Session;

class AuthAdminController extends AuthController {

	protected $request;
	protected $userModel;

	public function __construct() {
		parent::__construct();
		$this->request = new Request();
		$this->userModel = new User();
	}

	public function showLoginPage() {
		ViewRender::render('admin/login',['request' => $this->request]);
	}

	public function handleLogin() {
		$request = $this->request->post();
		$errors = LoginValidate::validate($request) ?? [];

		if (!empty($errors)) {
			$this->request->redirectWithErrors('/admin/auth/login', $errors);
			exit;
		}

		if (!CSRF::validatePostRequest()) {
			CSRF::refreshToken();
			$this->request->redirectWithErrors('/admin/auth/login', 'Lỗi xảy ra. Vui lòng thử lại');
			exit;
		}

		if (!$this->auth->login($request['email'], $request['password'])) {
			$this->request->redirectWithErrors('/admin/auth/login', 'Email hoặc mật khẩu không đúng');
			exit;
		}

		// Check if user session exists and role matches
        $this->userModel->updateColumn(Session::get('user')['id'], 'last_login', date('Y-m-d H:s:i'));

		$this->request->redirect('/admin/dashboard');
		exit;
	}

	public function logout() {
		$this->auth->logout();
		$this->request->redirect('/admin/auth/login');
		exit;
	}
}
