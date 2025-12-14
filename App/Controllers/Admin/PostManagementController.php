<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-09
 * Purpose: Post Management Controller
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseRentalPostController;
use Core\CSRF;
use Core\Response;
use Core\ViewRender;

class PostManagementController extends BaseRentalPostController {
    protected $title = "Quản lí bài đăng";
    protected $role = 'admin';
    protected $ownerId = 0;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Get pagination parameters
        $page = $this->request->get('page') != '' ? (int) $this->request->get('page') : 1;
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
            $highlightPost = $this->rentalPostModel->getRentalPostById((int) $highlightId);
            if ($highlightPost) {
                $found = false;
                foreach ($posts as $p) {
                    if (isset($p['id']) && (int) $p['id'] === (int) $highlightPost['id']) {
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
                    $totalPosts = (int) $totalPosts + 1;
                }
            }
        }

        // Calculate pagination
        $pagination = $this->getPagination($page, $totalPosts, $limit, $offset);
        // Build query parameters for pagination links
        $queryParams = array_filter([
            'search' => $search,
            'approval_status' => $approval_status,
            'rental_category_id' => $rental_category_id,
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
            'houses' => $this->getAllHouse(),
            'currentFilters' => [
                'search' => $search,
                'approval_status' => $approval_status,
                'rental_category_id' => $rental_category_id,
            ],
            'title' => $this->title,
        ], 'admin/layouts/app');
    }

    public function pendingPostPage() {
        $pendingPost = $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);

        ViewRender::renderWithLayout('admin/posts/pending', [
            'pendingPost' => $pendingPost,
        ], 'admin/layouts/app');
    }

    public function approvedPostPage() {
        $approvedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['approved']);
        ViewRender::renderWithLayout('admin/posts/approved', [
            'approvedPost' => $approvedPost,
        ], 'admin/layouts/app');
    }

    public function rejectedPostPage() {
        $rejectedPost = $this->rentalPostModel->getCountRentalPostsByStatus(['rejected']);
        ViewRender::renderWithLayout('admin/posts/rejected', [
            'rejectedPost' => $rejectedPost,
        ], 'admin/layouts/app');
    }

    // Added by Huy Nguyen on 2025-11-07 to approve all or single posts in pending status
    public function approvedPost() {
        $requests = $this->request->post();

        if ($requests['type'] != 'all') {
            if (!isset($requests['posts_id']) || empty($requests['posts_id'])) {
                Response::json(['status' => 'error', 'msg' => 'Chưa có bài đăng nào được chọn', 'token' => CSRF::getTokenRefresh()], 400);
            }
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $postIds = [];

        if ($requests['type'] == 'all') {
            $pendingPosts = $this->rentalPostModel->getColumn(['id'], 'rental_posts', '', ['approval_status' => ['value' => 'pending']]);

            if (count($pendingPosts) <= 0) {
                Response::json(['status' => 'error', 'msg' => 'Không còn bài đăng nào cần duyệt', 'token' => CSRF::getTokenRefresh()], 400);
            }

            foreach ($pendingPosts as $post) {
                $postIds[] = $post['id'];
            }
        }

        if (!$this->rentalPostModel->updateColumn($requests['type'] != 'all' ? $requests['posts_id'] : $postIds, 'approval_status', 'approved')) {
            Response::json(['status' => 'error', 'msg' => 'Duyệt không thành công. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $this->rentalPostModel->updateColumn($requests['type'] != 'all' ? $requests['posts_id'] : $postIds, 'approval_reason', '-');

        Response::json(['status' => 'success', 'msg' => 'Bài đăng đã được duyệt thành công', 'token' => CSRF::getTokenRefresh()], 200);
    }

    // Added by Huy Nguyen on 2025-11-30 to reject single posts in pending status
    public function rejectPost() {
        $requests = $this->request->post();

        if (!isset($requests['post_id']) || empty($requests['post_id'])) {
            Response::json(['status' => 'error', 'msg' => 'Chưa có bài đăng nào được chọn', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (empty($requests['violation_type']) || empty($requests['violation_content'])) {
            Response::json(['status' => 'error', 'msg' => 'Vui lòng cung cấp đầy đủ thông tin lý do từ chối', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $reason = "Loại: " . $requests['violation_type'] . "; Nội dung: " . $requests['violation_content'];

        if (!$this->rentalPostModel->updateColumn((int) $requests['post_id'], 'approval_status', 'rejected')) {
            Response::json(['status' => 'error', 'msg' => 'Từ chối không thành công. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $this->rentalPostModel->updateColumn((int) $requests['post_id'], 'approval_reason', $reason);

        Response::json(['status' => 'success', 'msg' => 'Bài đăng đã bị từ chối thành công', 'token' => CSRF::getTokenRefresh()], 200);
    }

    // Added by Huy Nguyen on 2025-11-30 to get rejection detail of a post
    public function getRejectionDetail() {
        $postId = $this->request->get('post_id') ?? '';

        if (empty($postId)) {
            Response::json(['status' => 'error', 'msg' => 'Chưa có bài đăng nào được chọn', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $post = $this->rentalPostModel->getColumn('approval_reason', 'rental_posts', (int) $postId);

        if (empty($post)) {
            Response::json(['status' => 'error', 'msg' => 'Bài đăng không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $parts = explode(';', $post['approval_reason']);

        $type = trim(str_replace('Loại:', '', $parts[0]));
        $content = trim(str_replace('Nội dung:', '', $parts[1]));

        Response::json(['status' => 'success', 'data' => ['violation_type' => $type, 'violation_content' => $content], 'token' => CSRF::getTokenRefresh()], 200);
    }
}
