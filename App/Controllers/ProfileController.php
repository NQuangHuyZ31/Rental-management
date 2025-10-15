<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-18
 * Purpose: Build Base Profile Controller
 */

namespace App\Controllers;

use App\Controllers\Customer\CustomerController;
use App\Models\User;
use App\Requests\FileValidate;
use App\Requests\PasswordValidate;
use App\Requests\UpdateProfileValidate;
use Core\CSRF;
use Core\Request;
use Core\Response;
use Helpers\UploadClound;

class ProfileController extends CustomerController {
    protected $userModel;
    protected $request;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->request = new Request();
    }

    protected function update() {
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

	public function updateProfilePicture() {
		$data = $this->request->post();
		$file = $this->request->file('profilePicture');
		$error = FileValidate::validate($file);

        if (!empty($error)) {
            Response::json(['status' => 'error', 'message' => $error, 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        // Check xem có tồn tại ảnh đại diện trong database không
        $user = $this->userModel->getUserById($this->userID);

        if ($user['avatar'] != '') {
            UploadClound::delete(UploadClound::getPublicIdFromUrl($user['avatar']));
        }

        $filename = uniqid() . '_' . $file['name'];
        
        $url = UploadClound::upload($file['tmp_name'], 'avatar', $filename);

        if (!$url) {
            Response::json(['status' => 'error', 'message' => 'Cập nhật ảnh đại diện thất bại!', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        $this->userModel->updateColumn($this->userID, 'avatar', $url);

		Response::json(['status' => 'success', 'message' => 'Cập nhật ảnh đại diện thành công!', 'token' => CSRF::getTokenRefresh()], 200);
		exit;
	}

    protected function changePassword() {
        $data = $this->request->post();

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        if (empty($data['current_password']) || empty($data['password']) || empty($data['confirm_password'])) {
            Response::json(['status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        $errors = PasswordValidate::validate($data);
        if (!empty($errors)) {
            Response::json(['status' => 'error', 'message' => $errors, 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        $user = $this->userModel->getUserById($this->userID);
        if (!$user) {
            Response::json(['status' => 'error', 'message' => 'Không tìm thấy người dùng', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        if (!password_verify($data['current_password'], $user['password'])) {
            Response::json(['status' => 'error', 'message' => 'Mật khẩu hiện tại không đúng', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        $updated = $this->userModel->updateColumn($this->userID, 'password', $hashed);

        if (!$updated) {
            Response::json(['status' => 'error', 'message' => 'Đổi mật khẩu thất bại', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        Response::json(['status' => 'success', 'message' => 'Đổi mật khẩu thành công', 'token' => CSRF::getTokenRefresh()], 200);
        exit;
    }
}
