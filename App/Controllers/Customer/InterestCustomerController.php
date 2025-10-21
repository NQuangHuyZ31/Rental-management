<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-23
 * Purpose: Interest Customer Controller
 */

namespace App\Controllers\Customer;

use App\Controllers\Customer\CustomerController;
use Core\CSRF;
use Core\Response;
use Core\ViewRender;

class InterestCustomerController extends CustomerController {
    protected $sidebar = true;
    protected $noFooter = true;
    protected $title = 'Quan tâm';

    public function __construct() {
        parent::__construct();
    }

    public function interests() {
        $page = (int) ($this->request->get('page') ?? 1);
        $limit = 3;
        $offset = ($page - 1) * $limit;

        $interestPost = $this->rentalPostInterestModel->getByUserId($this->user['id'], null, $limit, $offset);
        $totalInterestPost = count($this->rentalPostInterestModel->getByUserId($this->user['id']));
        $pagination = $this->getPagination($page, $totalInterestPost, $limit, $offset);

        ViewRender::renderWithLayout(
            'customer/favorite/favorites',
            [
                'sidebar' => $this->sidebar,
                'noFooter' => $this->noFooter,
                'title' => $this->title,
                'sidebarData' => $this->sidebarData(),
                'pagination' => $pagination,
                'posts' => $interestPost,
            ],
            'customer/layouts/app'
        );
    }

    public function deletePostInterest() {
        $requests = $this->request->post();

        if (empty($requests['postId'])) {
            Response::json(['status' => 'error', 'msg' => 'Bài đăng không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $postInterest = $this->rentalPostInterestModel->getByUserId($this->user['id'], $requests['postId'], '', '', true);

        if (!$postInterest) {
            Response::json(['status' => 'error', 'msg' => 'Không thể xóa mục không phải của bạn', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if ($this->rentalPostInterestModel->updateColumn($postInterest['post_interest_id'], 'deleted', '1')) {
            Response::json(['status' => 'success', 'msg' => 'Xóa thành công', 'token' => CSRF::getTokenRefresh()], 200);
        } else {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi khi xóa. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

    }
}
