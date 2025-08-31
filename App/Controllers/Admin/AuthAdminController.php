<?php

/*
    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Handle login for admin
*/

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Requests\LoginValidate;
use Core\CSRF;
use Core\ViewRender;
use Core\Request;

class AuthAdminController extends Controller {

	protected $request;

	public function __construct() {
		parent::__construct();
		$this->request = new Request();
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

		$this->request->redirect('/admin');
		exit;
	}
}
