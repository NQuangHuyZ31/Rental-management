<?php
/*
    Author: Nguyen Xuan Duong
    Date: 2025-10-06
    Purpose: Landlord Banking Controller - show payment history
*/

namespace App\Controllers\Landlord;

use Core\ViewRender;
use Core\Session;
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

        // Count query
        $countQuery = $this->paymentHistoryModel
            ->table('payment_histories')
            ->select('COUNT(*) as total')
            ->join('invoices', 'payment_histories.invoice_id', '=', 'invoices.id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('payment_histories.deleted', 0)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('houses.deleted', 0)
            ->where('houses.owner_id', $ownerId);

        // Chỉ lọc theo selectedHouse nếu có
        if ($selectedHouse) {
            $countQuery->where('houses.id', $selectedHouse['id']);
        }
        
        if (!empty($month)) {
            $countQuery->where('invoices.invoice_month', $month);
        }

        $totalCountRow = $countQuery->first();
        $totalCount = $totalCountRow['total'] ?? 0;

        // Data query
        $dataQuery = $this->paymentHistoryModel
            ->table('payment_histories')
            ->select([
                'payment_histories.*',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.ref_code',
                'invoices.invoice_status',
                'rooms.room_name',
                'houses.house_name',
                'users.username as payer_name'
            ])
            ->join('invoices', 'payment_histories.invoice_id', '=', 'invoices.id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->leftJoin('users', 'payment_histories.payer_id', '=', 'users.id')
            ->where('payment_histories.deleted', 0)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('houses.deleted', 0)
            ->where('houses.owner_id', $ownerId);

        // Chỉ lọc theo selectedHouse nếu có
        if ($selectedHouse) {
            $dataQuery->where('houses.id', $selectedHouse['id']);
        }

        if (!empty($month)) {
            $dataQuery->where('invoices.invoice_month', $month);
        }

        $histories = $dataQuery->orderBy('payment_histories.created_at', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();

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
        header('Content-Type: application/json');
        
        $ownerId = $this->user['id'] ?? null;
        $paymentId = $this->request->get('id');

        if (!$paymentId) {
            echo json_encode(['success' => false, 'message' => 'ID giao dịch không hợp lệ']);
            return;
        }

        try {
            $paymentDetail = $this->paymentHistoryModel->getPaymentHistoryDetail($paymentId);

            if (!$paymentDetail) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy giao dịch']);
                return;
            }

            // Kiểm tra quyền sở hữu - chỉ chủ nhà mới được xem giao dịch của nhà mình
            if ($paymentDetail['owner_id'] != $ownerId) {
                echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
                return;
            }

            echo json_encode([
                'success' => true,
                'data' => $paymentDetail
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Lỗi server: ' . $e->getMessage()
            ]);
        }
    }
}


