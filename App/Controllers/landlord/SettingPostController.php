<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-17
* Purpose: Build Setting Post Controller
*/

namespace App\Controllers\Landlord;

use Core\ViewRender;
use Core\CSRF;
use Core\Response;

class SettingPostController extends SettingController {

	public function __construct() {
		parent::__construct();
	}

	public function categories() {
		$systemCategories = $this->rentalCategory->getAllRentalCategories(false, true, '');
		$userCategories = $this->rentalCategory->getAllRentalCategories(true, false, '');
		
		return ViewRender::renderWithLayout('landlord/settings/categories', [
			'systemCategories' => $systemCategories,
			'userCategories' => $userCategories
		], 'landlord/settings/index');
	}

	public function createCategory() {
		$request = $this->request->post();

		if (!CSRF::validatePostRequest()) {
			Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$rentalCategory = $this->rentalCategory->getRentalCategoryById($request['category_id'], $this->userID);

		$dataRentalCategory = [
			'rental_category_name' => $request['rental_category_name'],
			'rental_category_status' => $request['rental_category_status'],
			'owner_id' => $this->userID ?? $rentalCategory['owner_id'],
			'created_at' => $rentalCategory['created_at'] ?? date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		if (!$rentalCategory) {
			$this->rentalCategory->createRentalCategory($dataRentalCategory);
			Response::json(['status' => 'success', 'message' => 'Tạo danh mục thành công', 'token' => CSRF::getTokenRefresh()], 200);
			exit;
		}

		$this->rentalCategory->updateRentalCategory($rentalCategory['id'], $dataRentalCategory);
		Response::json(['status' => 'success', 'message' => 'Cập nhật danh mục thành công', 'token' => CSRF::getTokenRefresh()], 200);
		exit;
	}

	public function deleteCategory() {
		$request = $this->request->post();

		if (!CSRF::validatePostRequest()) {
			Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$rentalCategory = $this->rentalCategory->getRentalCategoryById($request['category_id'], $this->userID);

		if (!$rentalCategory) {
			Response::json(['status' => 'error', 'message' => 'Danh mục không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$deleted = $this->rentalCategory->deleteRentalCategory($request['category_id']);

		if ($deleted) {
			Response::json(['status' => 'success', 'message' => 'Xóa danh mục thành công', 'token' => CSRF::getTokenRefresh()], 200);
			exit;
		} else {
			Response::json(['status' => 'error', 'message' => 'Không thể xóa danh mục. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}
	}
}