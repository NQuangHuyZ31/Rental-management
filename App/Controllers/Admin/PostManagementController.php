<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-09
* Purpose: Post Management Controller
*/

namespace App\Controllers\Admin;

use App\Controllers\BaseRentalPostController;
use Core\ViewRender;

class PostManagementController extends BaseRentalPostController {
    protected $title = "Quản lí bài đăng";
    protected $role = 'admin';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Get pagination parameters
        $page = $this->request->get('page') != '' ? (int)$this->request->get('page') : 1;
        $limit = $this->limit; // Items per page
        $offset = ($page - 1) * $limit;

        // Get filter parameters
        $search = $this->request->get('search') ?? '';
        $approval_status = $this->request->get('approval_status') ?? '';
        $rental_category_id = $this->request->get('rental_category_id') ?? '';

        // Get counts for stats
        $allPost = $this->rentalPostModel->getCountRentalPostsByStatus(['pending', 'approved', 'rejected']);
        $pendingPost = $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);
        $approvedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['approved']);
        $rejectedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['rejected']);

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

        // If admin requested a highlight_id, ensure that post is visible on the page by prepending it
        $highlightId = $this->request->get('highlight_id') ?? null;
        if (!empty($highlightId)) {
            $highlightPost = $this->rentalPostModel->getRentalPostById((int)$highlightId);
            if ($highlightPost) {
                $found = false;
                foreach ($posts as $p) {
                    if (isset($p['id']) && (int)$p['id'] === (int)$highlightPost['id']) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    array_unshift($posts, $highlightPost);
                    // Trim to limit so we don't exceed the page size
                    if (count($posts) > $limit) {
                        array_pop($posts);
                    }
                    // adjust total count so pagination still makes sense visually
                    $totalPosts = (int)$totalPosts + 1;
                }
            }
        }

        // Calculate pagination
        $pagination = $this->getPagination($page, $totalPosts, $limit, $offset);
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
            'rentalCategories' => $this->getAllRentalCategory(),
            'rentalAmenities' => $this->getAllRentalAmenity(),
            'pagination' => $pagination,
            'queryParams' => $queryParams,
            'currentFilters' => [
                'search' => $search,
                'approval_status' => $approval_status,
                'rental_category_id' => $rental_category_id
            ],
            'title' => $this->title
        ], 'admin/layouts/app');
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

