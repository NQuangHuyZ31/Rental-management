<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-11
 * Purpose: Profile Customer Controller
 */

namespace App\Controllers\Customer;

use App\Controllers\Customer\CustomerController;
use App\Models\User;
use App\Requests\UpdateProfileValidate;
use Core\CSRF;
use Core\Request;
use Core\Response;
use Core\ViewRender;

class ProfileCustomerController extends CustomerController {
    protected $sidebar = true;
    protected $noFooter = true;
	protected $userModel;
	protected $user;
	protected $request;
    protected $title = 'Thông tin cá nhân';

	public function __construct() {
		parent::__construct();
		$this->userModel = new User();
		$this->user = $this->userModel->getUserById($this->userID);
		$this->request = new Request();
	}
	
	public function profile() {
		$user = $this->user;
		ViewRender::renderWithLayout(
			'customer/profile',
			[
				'sidebar' => $this->sidebar,
				'noFooter' => $this->noFooter,
				'title' => $this->title,
				'sidebarData' => $this->sidebarData(),
				'user' => $user,
			],
			'customer/layouts/app'
		);
	}

	public function update() {
		$data = $this->request->post();
		$error = UpdateProfileValidate::validate($data);

		if (!empty($error)) {
			Response::json(['status' => 'error', 'message' => $error, 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		if (!CSRF::validatePostRequest()) {
			Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		if (!$this->userModel->updateUser($this->userID, $data)) {
			Response::json(['status' => 'error', 'message' => 'Cập nhật thông tin thất bại!', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		} else {
			Response::json(['status' => 'success', 'message' => 'Cập nhật thông tin thành công!', 'token' => CSRF::getTokenRefresh()], 200);
			exit;
		}
	}	
}
