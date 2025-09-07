<?php

/*
	Author: Huy Nguyen
	Date: 2025-09-05
	Purpose: Build Rental Post Controller
*/

namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use App\Models\RentalAmenity;
use App\Models\RentalCategory;
use App\Models\RentalPost;
use App\Requests\RentalPostValidate;
use Core\Response;
use Core\Session;
use Core\ViewRender;
use Core\Request;
use Exception;

class RentalPostController extends LandlordController {

	protected $rentalCategoryModel;
	protected $rentalAmenityModel;
	protected $rentalPostModel;
	protected $request;
	
	public function __construct() {
		parent::__construct();
		$this->rentalCategoryModel = new RentalCategory();
		$this->rentalAmenityModel = new RentalAmenity();
		$this->rentalPostModel = new RentalPost();
		$this->request = new Request();
	}
	
	public function index() {
		// Get filter parameters
		$page = (int) ($this->request->get('page') ?? 1);
		$limit = 3; // 3 rows x 3 columns
		$offset = ($page - 1) * $limit;
		$search = $this->request->get('search') ?? '';
		$category = $this->request->get('category') ?? '';
		$status = $this->request->get('status') ?? '';

		// Build filters array
		$filters = [];
		if (!empty($search)) $filters['search'] = $search;
		if (!empty($category)) $filters['category_id'] = $category;
		if (!empty($status)) $filters['status'] = $status;

		// Get posts and categories
		$rentalPosts = $this->getRentalPosts($filters, $limit, $offset);
		$totalPosts = $this->rentalPostModel->getTotalRentalPostsCount($filters);
		$rentalCategories = $this->rentalCategoryModel->getAllRentalCategories();
		$rentalAmenities = $this->rentalAmenityModel->getAllRentalAmenities();

		// Calculate pagination data
		$totalPages = ceil($totalPosts / $limit);
		$pagination = [
			'current_page' => $page,
			'total_pages' => $totalPages,
			'total_posts' => $totalPosts,
			'per_page' => $limit,
			'showing_from' => $offset + 1,
			'showing_to' => min($offset + $limit, $totalPosts)
		];

		ViewRender::render('landlord/Posts/index', [
			'rentalPosts' => $rentalPosts,
			'rentalCategories' => $rentalCategories,
			'rentalAmenities' => $rentalAmenities,
			'pagination' => $pagination,
			'filters' => $filters
		]);
	}

	public function create() {
		$data = $this->request->post();
		$images = $this->request->file('images');
		$error = RentalPostValidate::validate($data);

		if (!empty($error)) {
			Response::json([
				'status' => 'error',
				'error' => $error
			], 400);
			return;
		}

		try {
			// Create rental post
			$postId = $this->rentalPostModel->createRentalPost($data);
			
			if (!$postId) {
				Response::json([
					'status' => 'error',
					'error' => 'Không thể tạo tin đăng. Vui lòng thử lại!'
				], 500);
				return;
			}

			// Save amenities if provided
			if (isset($data['amenities']) && !empty($data['amenities'])) {
				$this->rentalPostModel->saveRentalPostAmenities($postId, $data['amenities']);
			}

			// // Save images if provided
			// if (!empty($images)) {
			// 	$this->rentalPostModel->uploadImageToCloud($postId, $images);
			// }

			Response::json([
				'status' => 'success',
				'message' => 'Tạo tin đăng thành công!',
				'post_id' => $postId
			], 200);

		} catch (Exception $e) {
			Response::json([
				'status' => 'error',
				'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
			], 500);
		}
	}

	public function update($id) {
		$data = $this->request->post();
		$images = $this->request->file('images');
		$error = RentalPostValidate::validate($data);

		if (!empty($error)) {
			Response::json([
				'status' => 'error',
				'error' => $error
			], 400);
			return;
		}

		try {
			// Update rental post
			$updated = $this->rentalPostModel->updateRentalPost($id, $data);
			
			if (!$updated) {
				Response::json([
					'status' => 'error',
					'error' => 'Không thể cập nhật tin đăng. Vui lòng thử lại!'
				], 500);
				return;
			}

			// Update amenities if provided
			if (isset($data['amenities'])) {
				$this->rentalPostModel->saveRentalPostAmenities($id, $data['amenities']);
			}

			// // Update images if provided
			// if (!empty($images)) {
			// 	$this->rentalPostModel->uploadImageToCloud($id, $images);
			// }

			Response::json([
				'status' => 'success',
				'message' => 'Cập nhật tin đăng thành công!'
			], 200);

		} catch (Exception $e) {
			Response::json([
				'status' => 'error',
				'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
			], 500);
		}
	}

	public function updateStatus($id) {
		$status = $this->request->post('status');
		
		if (!in_array($status, ['active', 'inactive', 'rented'])) {
			Response::json([
				'status' => 'error',
				'error' => 'Trạng thái không hợp lệ!'
			], 400);
			return;
		}

		try {
			$updated = $this->rentalPostModel->updateRentalPostStatus($id, $status);
			
			if ($updated) {
				Response::json([
					'status' => 'success',
					'message' => 'Cập nhật trạng thái thành công!'
				], 200);
			} else {
				Response::json([
					'status' => 'error',
					'error' => 'Không thể cập nhật trạng thái!'
				], 500);
			}
		} catch (Exception $e) {
			Response::json([
				'status' => 'error',
				'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
			], 500);
		}
	}

	public function delete($id) {
		try {
			$deleted = $this->rentalPostModel->deleteRentalPost($id);
			
			if ($deleted) {
				Response::json([
					'status' => 'success',
					'message' => 'Xóa tin đăng thành công!'
				], 200);
			} else {
				Response::json([
					'status' => 'error',
					'error' => 'Không thể xóa tin đăng!'
				], 500);
			}
		} catch (Exception $e) {
			Response::json([
				'status' => 'error',
				'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
			], 500);
		}
	}

	private function getRentalPosts($filters = [], $limit = 10, $offset = 0) {
		if (!empty($filters['search'])) {
			return $this->rentalPostModel->searchRentalPosts($filters['search'], $limit, $offset);
		} elseif (!empty($filters['category_id'])) {
			return $this->rentalPostModel->getRentalPostsByCategory($filters['category_id'], $limit, $offset);
		} elseif (!empty($filters['status'])) {
			return $this->rentalPostModel->getRentalPostsByStatus($filters['status'], $limit, $offset);
		} else {
			return $this->rentalPostModel->getAllRentalPosts($limit, $offset);
		}
	}

}