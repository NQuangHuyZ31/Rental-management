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
		$systemCategories = $this->rentalCategoryModel->getAllRentalCategories(false, true, '');
		$userCategories = $this->rentalCategoryModel->getAllRentalCategories(true, false, '');
		
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

		if (empty($request['rental_category_name'])) {
			Response::json(['status' => 'error', 'message' => 'Tên danh mục không được để trống', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$rentalCategory = $this->rentalCategoryModel->getRentalCategoryById($request['categoryId'], $this->user['id']);

		$dataRentalCategory = [
			'rental_category_name' => $request['rental_category_name'],
			'rental_category_status' => $request['rental_category_status'],
			'owner_id' => $this->user['id'] ?? $rentalCategory['owner_id'],
			'created_at' => $rentalCategory['created_at'] ?? date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		if (!$rentalCategory) {
			$this->rentalCategoryModel->createRentalCategory($dataRentalCategory);
			Response::json(['status' => 'success', 'message' => 'Tạo danh mục thành công', 'token' => CSRF::getTokenRefresh()], 200);
			exit;
		}

		$this->rentalCategoryModel->updateRentalCategory($rentalCategory['id'], $dataRentalCategory);
		Response::json(['status' => 'success', 'message' => 'Cập nhật danh mục thành công', 'token' => CSRF::getTokenRefresh()], 200);
		exit;
	}

	public function deleteCategory() {
		$request = $this->request->post();

		if (!CSRF::validatePostRequest()) {
			Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$rentalCategory = $this->rentalCategoryModel->getRentalCategoryById($request['categoryId'], $this->user['id']);

		if (!$rentalCategory) {
			Response::json(['status' => 'error', 'message' => 'Danh mục không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$deleted = $this->rentalCategoryModel->deleteRentalCategory($request['categoryId']);

		if ($deleted) {
			Response::json(['status' => 'success', 'message' => 'Xóa danh mục thành công', 'token' => CSRF::getTokenRefresh()], 200);
			exit;
		} else {
			Response::json(['status' => 'error', 'message' => 'Không thể xóa danh mục. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}
	}

	// ====================Amenities=====================
	public function amenities() {
		$systemAmenities = $this->rentalAmenityModel->getAllRentalAmenities(false, true, '');
		$userAmenities = $this->rentalAmenityModel->getAllRentalAmenities(true, false, '');
		
		return ViewRender::renderWithLayout('landlord/settings/amenities', [
			'systemAmenities' => $systemAmenities,
			'userAmenities' => $userAmenities
		], 'landlord/settings/index');
	}

	public function createAmenity() {
		$request = $this->request->post();

		if (!CSRF::validatePostRequest()) {
			Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		if (empty($request['rental_amenity_name'])) {
			Response::json(['status' => 'error', 'message' => 'Tên tiện ích không được để trống', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$rentalAmenity = $this->rentalAmenityModel->getRentalAmenityById($request['amenityId'], $this->user['id']);

		$dataRentalAmenity = [
			'rental_amenity_name' => $request['rental_amenity_name'],
			'rental_amenity_status' => $request['rental_amenity_status'],
			'owner_id' => $this->user['id'] ?? $rentalAmenity['owner_id'],
			'created_at' => $rentalAmenity['created_at'] ?? date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		if (!$rentalAmenity) {
			$this->rentalAmenityModel->createRentalAmenity($dataRentalAmenity);
			Response::json(['status' => 'success', 'message' => 'Tạo tiện ích thành công', 'token' => CSRF::getTokenRefresh()], 200);
			exit;
		}

		$this->rentalAmenityModel->updateRentalAmenity($rentalAmenity['id'], $dataRentalAmenity);
		Response::json(['status' => 'success', 'message' => 'Cập nhật tiện ích thành công', 'token' => CSRF::getTokenRefresh()], 200);
		exit;
	}

	public function deleteAmenity() {
		$request = $this->request->post();

		if (!CSRF::validatePostRequest()) {
			Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$rentalAmenity = $this->rentalAmenityModel->getRentalAmenityById($request['amenityId'], $this->user['id']);

		if (!$rentalAmenity) {
			Response::json(['status' => 'error', 'message' => 'Tiện ích không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$deleted = $this->rentalAmenityModel->deleteRentalAmenity($request['amenityId']);

		if ($deleted) {
			Response::json(['status' => 'success', 'message' => 'Xóa tiện ích thành công', 'token' => CSRF::getTokenRefresh()], 200);
			exit;
		} else {
			Response::json(['status' => 'error', 'message' => 'Không thể xóa tiện ích. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}
	}
}