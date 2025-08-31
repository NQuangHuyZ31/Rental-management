<?php

/*
    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Handle login for admin
*/

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Core\ViewRender;
use Core\Request;

class AuthAdminController extends Controller {

	protected $request;

	public function __construct() {
		parent::__construct();
		$this->request = new Request();
	}

	public function showLoginPage() {
		ViewRender::render('/admin/login',['request' => $this->request]);
	}
}
