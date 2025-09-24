<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-09
* Purpose: Post Management Controller
*/

namespace App\Controllers\Admin;

use Core\ViewRender;

class PostManagementController extends AdminController {

    public function index() {
        // Get pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Items per page
        $offset = ($page - 1) * $limit;

        // Get filter parameters
        $search = $_GET['search'] ?? '';
        $approval_status = $_GET['approval_status'] ?? '';
        $rental_category_id = $_GET['rental_category_id'] ?? '';

        // Get counts for stats
        $allPost = $this->rentalPostModel->getCountRentalPostsByStatus(['pending', 'approved', 'rejected']);
        $pendingPost = $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);
        $approvedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['approved']);
        $rejectedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['rejected']);
		$allCategory = $this->rentalCategoryModel->getAllRentalCategories();

		$filters = [];
        // Get posts with pagination using existing model methods
        if (!empty($search) || !empty($approval_status) || !empty($rental_category_id)) {
			$filters['search'] = $search;
			$filters['approval_status'] = $approval_status;
			$filters['rental_category_id'] = $rental_category_id;
			$posts = $this->rentalPostModel->searchRentalPosts($filters, $limit, $offset);
			$totalPosts = $this->rentalPostModel->getTotalRentalPostsCount($filters);
		} else {
			$posts = $this->rentalPostModel->searchRentalPosts($filters, $limit, $offset);
			$totalPosts = $this->rentalPostModel->getTotalRentalPostsCount();
		}

        // Calculate pagination
        $pagination = $this->calculatePagination($totalPosts, $page, $limit);
        // Build query parameters for pagination links
        $queryParams = array_filter([
            'search' => $search,
            'approval_status' => $approval_status,
            'rental_category_id' => $rental_category_id
        ]);

        ViewRender::renderWithLayout('admin/posts/posts', [
            'allPost' => $allPost,
            'pendingPost' => $pendingPost,
            'approvedPost' => $approvedPost,
            'rejectedPost' => $rejectedPost,
            'posts' => $posts,
            'allCategory' => $allCategory,
            'pagination' => $pagination,
            'queryParams' => $queryParams,
            'currentFilters' => [
                'search' => $search,
                'approval_status' => $approval_status,
                'rental_category_id' => $rental_category_id
            ]
        ], 'admin/layouts/app');
    }

    private function calculatePagination($totalItems, $currentPage, $itemsPerPage) {
        $totalPages = ceil($totalItems / $itemsPerPage);
        
        return [
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'total_items' => $totalItems,
            'items_per_page' => $itemsPerPage,
            'has_prev' => $currentPage > 1,
            'has_next' => $currentPage < $totalPages,
            'prev_page' => $currentPage > 1 ? $currentPage - 1 : 1,
            'next_page' => $currentPage < $totalPages ? $currentPage + 1 : $totalPages
        ];
    }

	public function pendingPostPage() {
		$pendingPost = $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);
		ViewRender::renderWithLayout('admin/posts/pending',[
			'pendingPost' => $pendingPost,
		],'admin/layouts/app');
	}
	
	public function approvedPostPage() {
		$approvedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['approved']);
		ViewRender::renderWithLayout('admin/posts/approved',[
			'approvedPost' => $approvedPost,
		],'admin/layouts/app');
	}
	
	public function rejectedPostPage() {
		$rejectedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['rejected']);
		ViewRender::renderWithLayout('admin/posts/rejected',[
			'rejectedPost' => $rejectedPost,
		],'admin/layouts/app');
	}
	
}

