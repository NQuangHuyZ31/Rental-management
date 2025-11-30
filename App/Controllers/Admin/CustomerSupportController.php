<?php
/*
Author: Huy Nguyen
Date: 2025-11-30
Purpose: Admin Customer Support Controller
 */

namespace App\Controllers\Admin;

use Core\CSRF;
use Core\Response;
use Core\Session;
use Core\ViewRender;

class CustomerSupportController extends AdminController {
    protected $title = "Hỗ trợ khách hàng";
    protected $role = 'admin';
    protected $ownerId = 0;
    protected $limit = 5;

    public function __construct() {
        parent::__construct();
    }

    // Added by Huy Nguyen on 2025-12-05 to show customer support page
    public function showCustomerSupportPage() {
        $page = $this->request->get('page') != '' ? (int) $this->request->get('page') : 1;
        $limit = $this->limit; // Items per page
        $offset = ($page - 1) * $limit;

        $totalcs = $this->customerSupportModel->getAll('customer_supports', [], 0, 'created_at', 'DESC');
        $allcsThisMonth = $this->customerSupportModel->getAll('customer_supports', [
            'created_at' => [
                [
                    'condition' => '>=',
                    'value' => date('Y-m-01 00:00:00'),
                ],
                [
                    'condition' => '<=',
                    'value' => date('Y-m-d H:i:s'),
                ],
            ],
        ], 0, 'created_at', 'DESC');

        $totalcsResolved = 0;

        foreach ($totalcs as $cs) {
            if (!empty($cs['date_process'])) {
                $totalcsResolved++;
            }
        }

        $csData = $this->customerSupportModel->getAll('customer_supports', [], $limit, 'created_at', 'DESC', $offset);
        $csDataProcessed = [];

        foreach ($csData as $cs) {
            // Additional processing if needed
            $item = $cs;

            if (!empty($cs['user_process_id'])) {
                $item['user_process_name'] = $this->userModel->getColumn('username', 'users', $cs['user_process_id']) ?? '';
            }

            $csDataProcessed[] = $item;
        }

        $pagination = $this->getPagination($page, count($totalcs), $limit, $offset);

        ViewRender::renderWithLayout('admin/customer-support/index', [
            'title' => $this->title,
            'allcs' => count($totalcs),
            'allcsThisMonth' => count($allcsThisMonth),
            'totalcsResolved' => $totalcsResolved,
            'csData' => $csDataProcessed,
            'pagination' => $pagination,
        ], 'admin/layouts/app');
    }

    // Added by Huy Nguyen on 2025-11-30 to handle resolved customer support
    public function handleResolved() {
        $requests = $this->request->post();

        if (empty($requests['customer_support_id']) || empty($requests['resolved_type']) || empty($requests['resolved_content'])) {
            Response::json(['status' => 'error', 'msg' => 'Vui lòng điền đầy đủ thông tin.', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Yêu cầu không hợp lệ. Vui lòng thử lại.', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $content = "Cách hỗ trợ: " . $requests['resolved_type'] . "; Nội dung hỗ trợ: " . $requests['resolved_content'];

        $this->customerSupportModel->updateColumn($requests['customer_support_id'], 'user_process_id', Session::get('user')['id']);
        $this->customerSupportModel->updateColumn($requests['customer_support_id'], 'date_process', date('Y-m-d H:i:s'));
        $this->customerSupportModel->updateColumn($requests['customer_support_id'], 'description_process', $content);

        Response::json(['status' => 'success', 'msg' => 'Cập nhật yêu cầu hỗ trợ thành công.', 'token' => CSRF::getTokenRefresh()], 200);
    }

	// Added by Huy Nguyen on 2025-11-30 to delete customer support entry
	public function deleteCS() {
		$requests = $this->request->post();

		if (empty($requests['cs_id'])) {
			Response::json(['status' => 'error', 'msg' => 'Yêu cầu không hợp lệ.', 'token' => CSRF::getTokenRefresh()], 400);
		}

		if (!CSRF::validatePostRequest()) {
			Response::json(['status' => 'error', 'msg' => 'Yêu cầu không hợp lệ. Vui lòng thử lại.', 'token' => CSRF::getTokenRefresh()], 400);
		}

		$this->customerSupportModel->updateColumn($requests['cs_id'], 'deleted', 1);

		Response::json(['status' => 'success', 'msg' => 'Xóa yêu cầu hỗ trợ thành công.', 'token' => CSRF::getTokenRefresh()], 200);
	}
}