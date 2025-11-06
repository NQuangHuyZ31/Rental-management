<?php
/*
    Author: Nguyen Xuan Duong
    Date: 2025-10-06
    Purpose: Landlord Banking Controller - show payment history
*/

namespace App\Controllers\Landlord;

use Core\ViewRender;
use Core\Response;
use App\Models\PaymentHistory;
use Exception;

class BankingController extends LandlordController {
    private $paymentHistoryModel;

    public function __construct() {
        parent::__construct();
        $this->paymentHistoryModel = new PaymentHistory();
    }

    public function index() {
        $ownerId = $this->user['id'] ?? null;

        // Lấy selectedHouse từ URL hoặc parent controller
        [$selectedHouse, $houses] = $this->getSelectedHouse($ownerId, $this->request->get('house_id'));

        $page = max(1, intval($this->request->get('page') ?? 1));
        $limit = max(1, intval($this->request->get('limit') ?? 10));
        $offset = ($page - 1) * $limit;

        $month = $this->request->get('month'); // format: mm-YYYY

        // Sử dụng method từ model thay vì viết SQL trong controller
        $houseId = $selectedHouse ? $selectedHouse['id'] : null;
        $totalCount = $this->paymentHistoryModel->getPaymentHistoryCountByOwner($ownerId, $houseId, $month);
        $histories = $this->paymentHistoryModel->getPaymentHistoriesByOwner($ownerId, $houseId, $month, $limit, $offset);

        ViewRender::render('landlord/banking/index', [
            'houses' => $houses,
            'selectedHouse' => $selectedHouse,
            'paymentHistories' => $histories,
            'page' => $page,
            'limit' => $limit,
            'total' => $totalCount,
        ]);
    }

    public function detail() {
        $ownerId = $this->user['id'] ?? null;
        $paymentId = $this->request->get('id');

        if (!$paymentId) {
            Response::json(['success' => false, 'message' => 'ID giao dịch không hợp lệ!'], 400);
            return;
        }

        try {
            $paymentDetail = $this->paymentHistoryModel->getPaymentHistoryDetail($paymentId);

            if (!$paymentDetail) {
                Response::json(['success' => false, 'message' => 'Không tìm thấy giao dịch!'], 404);
                return;
            }

            // Kiểm tra quyền sở hữu - chỉ chủ nhà mới được xem giao dịch của nhà mình
            if ($paymentDetail['owner_id'] != $ownerId) {
                Response::json(['success' => false, 'message' => 'Không có quyền truy cập!'], 403);
                return;
            }

            Response::json([
                'success' => true,
                'data' => $paymentDetail
            ], 200);
        } catch (Exception $e) {
            Response::json([
                'success' => false, 
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage() . '!'
            ], 500);
        }
    }
}


