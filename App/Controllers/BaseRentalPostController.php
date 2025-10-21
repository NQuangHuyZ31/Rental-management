<?php

/*
Author: Huy Nguyen
Date: 2025-10-17
Purpose: base rental post controller
 */

namespace App\Controllers;

use App\Models\RentalAmenity;
use App\Models\RentalCategory;
use App\Models\RenTalPost;
use App\Requests\RentalPostValidate;
use Core\CSRF;
use Core\QueryBuilder;
use Core\Request;
use Core\Response;
use Exception;
use Queue\UploadImageOnCloud;

class BaseRentalPostController extends BaseCustomerController {
	protected $role = '';
    protected $limit = 10;
	protected $rentalCategoryModel;
	protected $rentalAmenityModel;
	protected $uploadImageOnCloud;
	protected $queryBuilder;

    public function __construct() {
		parent::__construct();
        $this->request = new Request();
		$this->rentalPostModel = new RenTalPost();
		$this->rentalCategoryModel = new RentalCategory();
		$this->rentalAmenityModel = new RentalAmenity();
		$this->uploadImageOnCloud = new UploadImageOnCloud();
		$this->queryBuilder = new QueryBuilder();
    }

	public function create() {
        $data = $this->request->post();
        $error = RentalPostValidate::validate($data);

        if (!empty($error)) {
            Response::json(['status' => 'error', 'error' => $error, 'token' => CSRF::getTokenRefresh()], 400);
            return;
        }
        // Kiểm tra ảnh từ $_FILES
        if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
            $error = 'Ảnh không được để trống';
            Response::json(['status' => 'error', 'error' => $error, 'token' => CSRF::getTokenRefresh()], 400);
            return;
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'error' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 401);
            return;
        }

        try {
            // Create rental post
            $postId = $this->rentalPostModel->createRentalPost($data);

            if (!$postId) {
                Response::json(['status' => 'error', 'error' => 'Không thể tạo tin đăng. Vui lòng thử lại!', 'token' => CSRF::getTokenRefresh()], 400);
                return;
            }

            // Lưu files tạm thời trước khi dispatch job
            $savedFiles = $this->saveTemporaryFiles($_FILES['images'], $postId);

            // Xử lý upload ảnh
            $this->uploadImageOnCloud->dispatch(['post_id' => $postId, 'images' => $savedFiles]);
            Response::json(['status' => 'success', 'message' => 'Tạo tin đăng thành công! Đang upload ảnh...', 'token' => CSRF::getTokenRefresh()], 200);
        } catch (\Exception $e) {
            Response::json(['status' => 'error', 'error' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 500);
        }
    }

	public function getPost() {
		$postId = $this->request->get('post_id');

		if ($postId == '') {
			Response::json(['status' => 'error', 'error' => 'Bài đăng không tồn tại!'], 400);
		}

		$post = $this->rentalPostModel->getRentalPostById($postId, $this->role);

		if ($post) {
			Response::json(['status' => 'success', 'post' => $post], 200);
		} else {
			Response::json(['status' => 'error', 'error' => 'Bài đăng không tồn tại!'], 400);
		}
	}

    public function update() {
        $data = $this->request->post();
        $images = $this->request->file('images');
        $error = RentalPostValidate::validate($data);

        if (!empty($error)) {
            Response::json(['status' => 'error', 'error' => $error, 'token' => CSRF::getTokenRefresh()], 400);
            return;
        }

        try {
            $post = $this->rentalPostModel->getRentalPostById($data['post_id'], $this->role);
            // Update rental post
            if (!empty($post)) {
                $updated = $this->rentalPostModel->updateRentalPost($post['id'], $data);
            } else {
                Response::json(['status' => 'error', 'error' => 'Không thể cập nhật tin đăng. Vui lòng thử lại!', 'token' => CSRF::getTokenRefresh()], 500);
                return;
            }

            if (!isset($images) || !empty($images['name'][0])) {
                $savedFiles = $this->saveTemporaryFiles($images, $post['id']);
                $this->uploadImageOnCloud->dispatch(['post_id' => $post['id'], 'images' => $savedFiles, 'prev_images' => json_decode($post['images'])]);
            }

            if (!$updated) {
                Response::json(['status' => 'error', 'error' => 'Không thể cập nhật tin đăng. Vui lòng thử lại!', 'token' => CSRF::getTokenRefresh()], 500);
                return;
            }

            Response::json(['status' => 'success', 'message' => 'Cập nhật tin đăng thành công!' . (!empty($images) ? ' Đang upload ảnh...' : ''), 'token' => CSRF::getTokenRefresh()], 200);
        } catch (Exception $e) {
            Response::json(['status' => 'error', 'error' => 'Có lỗi xảy ra: ' . $e->getMessage(), 'token' => CSRF::getTokenRefresh()], 500);
        }
    }

    public function updateStatus() {

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'error' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getToken()], 401);
            return;
        }

        CSRF::refreshToken();

        try {
            $updated = $this->rentalPostModel->updateRentalPostStatus($this->request->post('post_id'), $this->request->post('status'), $this->role);

            if ($updated) {
                Response::json(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công!', 'token' => CSRF::getToken()], 200);
            } else {
                Response::json(['status' => 'error', 'error' => 'Không thể cập nhật trạng thái!', 'token' => CSRF::getToken()], 400);
            }
        } catch (Exception $e) {
            Response::json(['status' => 'error', 'error' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getToken()], 500);
        }
    }

    public function delete() {
        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'error' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getToken()], 401);
            return;
        }

        CSRF::refreshToken();

        try {
            if ($this->request->post('post_id') == '') {
                Response::json(['status' => 'error', 'error' => 'Bài đăng không tồn tại!', 'token' => CSRF::getToken()], 400);
                return;
            }

            $deleted = $this->rentalPostModel->deleteRentalPost($this->request->post('post_id'));

            if ($deleted) {
                Response::json(['status' => 'success', 'message' => 'Xóa bài đăng thành công!', 'token' => CSRF::getToken()], 200);
            } else {
                Response::json(['status' => 'error', 'error' => 'Không thể xóa bài đăng!', 'token' => CSRF::getToken()], 400);
            }
        } catch (Exception $e) {
            Response::json(['status' => 'error', 'error' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getToken()], 500);
        }
    }

    private function getRentalPosts($filters = [], $limit = 10, $offset = 0) {
        return $this->rentalPostModel->searchRentalPosts($filters, $limit, $offset, true);
    }

    /**
     * Lưu files tạm thời để queue worker có thể xử lý sau
     */
    private function saveTemporaryFiles($files, $postId) {
        $savedFiles = [
            'name' => [],
            'type' => [],
            'tmp_name' => [],
            'error' => [],
            'size' => [],
        ];

        $fileCount = count($files['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            if (empty($files['name'][$i])) {
                continue;
            }

            // Tạo thư mục lưu trữ tạm thời
            $tempDir = ROOT_PATH . '/temp_uploads/' . $postId;
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Tạo tên file mới
            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $newFileName = 'image_' . $i . '_' . time() . '.' . $extension;
            $newFilePath = $tempDir . '/' . $newFileName;

            // Copy file từ temp directory sang thư mục lưu trữ
            if (copy($files['tmp_name'][$i], $newFilePath)) {
                $savedFiles['name'][] = $files['name'][$i];
                $savedFiles['type'][] = $files['type'][$i];
                $savedFiles['tmp_name'][] = $newFilePath;
                $savedFiles['error'][] = $files['error'][$i];
                $savedFiles['size'][] = $files['size'][$i];
            }
        }

        return $savedFiles;
    }

    public function getAllRentalCategory() {
        return $this->rentalCategoryModel->getAllRentalCategories();
    }

    public function getAllRentalAmenity() {
        return $this->rentalAmenityModel->getAllRentalAmenities();
    }
}
