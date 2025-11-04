<?php

/*
Author: Nguyen Xuan Duong
Date: 2025-09-12
Purpose: Build Invoice Controller
 */

namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use App\Models\Invoice;
use Core\CSRF;
use Core\Session;
use Core\ViewRender;
use Helpers\Validate;

class InvoiceController extends LandlordController {
    private $invoiceModel;

    public function __construct() {
        parent::__construct();
        $this->invoiceModel = new Invoice();
    }

    public function index() {

        // Sử dụng logic chung từ LandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($this->user['id'], $this->request->get('house_id'));

        // Lấy tháng và năm hiện tại (mặc định là tháng hiện tại)
        $currentMonth = date('n');
        $currentYear = date('Y');
        $selectedMonth = $this->request->get('month', $currentMonth);
        $selectedYear = $this->request->get('year', $currentYear);

        // Lấy danh sách hóa đơn theo tháng/năm
        $invoices = $this->invoiceModel->getInvoicesForTable($this->user['id'], $selectedMonth, $selectedYear, $selectedHouseId);

        // Lấy thống kê hóa đơn
        $stats = $this->invoiceModel->getMonthlyInvoiceSummary($this->user['id'], $selectedMonth, $selectedYear, $selectedHouseId);

        ViewRender::render('landlord/invoice/index', [
            'selectedHouse' => $selectedHouse,
            'houses' => $houses,
            'selectedHouseId' => $selectedHouseId,
            'invoices' => $invoices,
            'stats' => $stats,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
        ]);
    }

    /**
     * Lấy chi tiết hóa đơn để hiển thị modal
     */
    public function viewInvoice($invoiceId = null) {
        // Đảm bảo không có output trước JSON
        if (ob_get_level()) {
            ob_clean();
        }

        // Set header để đảm bảo trả về JSON
        header('Content-Type: application/json');

        try {
            // Nếu không có $invoiceId từ parameter, thử lấy từ request
            if (!$invoiceId) {
                $invoiceId = $this->request->get('id');
            }

            if (!$invoiceId || !is_numeric($invoiceId)) {
                throw new \Exception('ID hóa đơn không hợp lệ');
            }

            // Lấy chi tiết hóa đơn
            $invoice = $this->invoiceModel->getInvoiceForDisplay($invoiceId, $this->user['id']);

            if (!$invoice) {
                throw new \Exception('Không tìm thấy hóa đơn');
            }

            // Lấy danh sách dịch vụ chi tiết
            $serviceDetails = $this->invoiceModel->getInvoiceServiceDetails($invoiceId, $this->user['id']);

            echo json_encode([
                'success' => true,
                'invoice' => $invoice,
                'serviceDetails' => $serviceDetails ?: [],
                'csrf_token' => CSRF::generateToken(),
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken(),
            ]);
        }

        exit; // Đảm bảo không có output nào khác
    }

    /**
     * Cập nhật trạng thái hóa đơn
     */
    public function updateStatus() {
        try {
            $invoiceId = $this->request->post('invoice_id');
            $status = $this->request->post('status');

            if (!$invoiceId || !$status) {
                throw new \Exception('Dữ liệu không hợp lệ');
            }

            $validStatuses = ['pending', 'paid', 'overdue'];
            if (!in_array($status, $validStatuses)) {
                throw new \Exception('Trạng thái không hợp lệ');
            }

            $result = $this->invoiceModel->updateInvoiceStatus($invoiceId, $status, $this->user['id']);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật trạng thái thành công',
                    'csrf_token' => CSRF::generateToken(),
                ]);
            } else {
                throw new \Exception('Không thể cập nhật trạng thái');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken(),
            ]);
        }
    }

    /**
     * Cập nhật thông tin hóa đơn
     */
    public function update() {
        try {
            $invoiceId = $this->request->post('invoice_id');

            if (!$invoiceId || !is_numeric($invoiceId)) {
                throw new \Exception('ID hóa đơn không hợp lệ');
            }

            // Validate CSRF token
            if (!CSRF::verifyToken($this->request->post('csrf_token'))) {
                throw new \Exception('Dữ liệu không hợp lệ');
            }

            // Lấy dữ liệu từ form
            $data = [
                'invoice_name' => $this->request->post('invoice_name'),
                'invoice_month' => $this->request->post('invoice_month'),
                'invoice_day' => $this->request->post('invoice_day'),
                'due_date' => $this->request->post('due_date'),
                'note' => $this->request->post('note'),
                'services' => $this->request->post('services') ?: [],
            ];

            // Validate dữ liệu sử dụng Helper Validate
            $errors = Validate::validateInvoiceData($data);
            if (!empty($errors)) {
                $this->request->redirectWithError('/landlord/invoice', 'Dữ liệu không hợp lệ: ' . implode(', ', $errors));
                return;
            }

            // Cập nhật hóa đơn
            $result = $this->invoiceModel->updateInvoice($invoiceId, $data, $this->user['id']);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord/invoice', 'Cập nhật hóa đơn thành công!');
            } else {
                throw new \Exception('Không thể cập nhật hóa đơn');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord/invoice', $e->getMessage());
        }
    }

    /**
     * Lấy form tạo hóa đơn với danh sách dịch vụ của phòng
     */
    public function createForm($roomId = null) {
        // Đảm bảo không có output trước JSON
        if (ob_get_level()) {
            ob_clean();
        }

        // Set header để đảm bảo trả về JSON
        header('Content-Type: application/json');

        try {
            // Nếu không có $roomId từ parameter, thử lấy từ request
            if (!$roomId) {
                $roomId = $this->request->get('id');
            }

            if (!$roomId || !is_numeric($roomId)) {
                throw new \Exception('ID phòng không hợp lệ');
            }

            // Lấy thông tin phòng
            $roomModel = new \App\Models\Room();
            $room = $roomModel->getRoomById($roomId, $this->user['id']);

            if (!$room) {
                throw new \Exception('Không tìm thấy phòng hoặc bạn không có quyền truy cập');
            }

            // Lấy danh sách dịch vụ của phòng
            $serviceModel = new \App\Models\Service();
            $services = $serviceModel->getServicesByRoomId($roomId);

            echo json_encode([
                'success' => true,
                'room' => $room,
                'services' => $services ?: [],
                'csrf_token' => CSRF::generateToken(),
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken(),
            ]);
        }

        exit; // Đảm bảo không có output nào khác
    }

    /**
     * Tạo hóa đơn mới
     */
    public function create() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra. Vui lòng thử lại');
            return;
        }

        try {
            // Lấy dữ liệu từ form
            $data = [
                'room_id' => $this->request->post('room_id'),
                'invoice_name' => $this->request->post('invoice_name'),
                'invoice_month' => $this->request->post('invoice_month'),
                'invoice_day' => $this->request->post('invoice_day'),
                'due_date' => $this->request->post('due_date'),
                'rental_amount' => $this->request->post('rental_amount'),
                'note' => $this->request->post('note'),
                'services' => $this->request->post('services') ?: [],
            ];

            // Validate dữ liệu sử dụng Helper Validate
            $errors = Validate::validateCreateInvoiceData($data);
            if (!empty($errors)) {
                // Store validation errors in session to display
                Session::set('validation_errors', $errors);
                Session::set('old_input', $data);
                $this->request->redirectWithError('/landlord', 'Vui lòng kiểm tra lại thông tin đã nhập');
                return;
            }

            // Tạo hóa đơn
            $result = $this->invoiceModel->createInvoice($data, $this->user['id']);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Tạo hóa đơn thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi tạo hóa đơn');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Đánh dấu hóa đơn đã thanh toán
     */
    public function markAsPaid() {
        try {
            $invoiceId = $this->request->post('invoice_id');

            if (!$invoiceId || !is_numeric($invoiceId)) {
                throw new \Exception('ID hóa đơn không hợp lệ');
            }

            // Validate CSRF token
            if (!CSRF::verifyToken($this->request->post('csrf_token'))) {
                throw new \Exception('Dữ liệu không hợp lệ');
            }

            // Kiểm tra quyền sở hữu hóa đơn trước khi cập nhật
            $invoice = $this->invoiceModel->getInvoiceById($invoiceId, $this->user['id']);
            if (!$invoice) {
                throw new \Exception('Không tìm thấy hóa đơn hoặc bạn không có quyền cập nhật');
            }

            // Kiểm tra trạng thái hiện tại - chỉ cho phép cập nhật hóa đơn chưa thanh toán
            if ($invoice['invoice_status'] === 'paid') {
                throw new \Exception('Hóa đơn đã được đánh dấu thanh toán rồi');
            }

            // Cập nhật trạng thái hóa đơn thành "paid" và cập nhật pay_at
            $result = $this->invoiceModel->updateInvoiceStatus($invoiceId, 'paid', $this->user['id']);

            if ($result) {
                // Cập nhật pay_at field với thời gian hiện tại
                $this->invoiceModel->updateColumn($invoiceId, 'pay_at', date('Y-m-d H:i:s'));
                $this->request->redirectWithSuccess('/landlord/invoice', 'Đánh dấu hóa đơn đã thanh toán thành công!');
            } else {
                throw new \Exception('Không thể cập nhật trạng thái hóa đơn');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord/invoice', $e->getMessage());
        }
    }

    /**
     * Xóa hóa đơn
     */
    public function delete() {
        try {
            $invoiceId = $this->request->post('invoice_id');

            if (!$invoiceId || !is_numeric($invoiceId)) {
                throw new \Exception('ID hóa đơn không hợp lệ');
            }

            // Validate CSRF token
            if (!CSRF::verifyToken($this->request->post('csrf_token'))) {
                throw new \Exception('Dữ liệu không hợp lệ');
            }

            // Kiểm tra quyền sở hữu hóa đơn trước khi xóa
            $invoice = $this->invoiceModel->getInvoiceById($invoiceId, $this->user['id']);
            if (!$invoice) {
                throw new \Exception('Không tìm thấy hóa đơn hoặc bạn không có quyền xóa');
            }

            // Kiểm tra trạng thái thanh toán - chỉ cho phép xóa hóa đơn chưa thanh toán
            if ($invoice['invoice_status'] === 'paid') {
                throw new \Exception('Không thể xóa hóa đơn đã thanh toán');
            }

            // Xóa hóa đơn (soft delete)
            $result = $this->invoiceModel->deleteInvoice($invoiceId);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord/invoice', 'Xóa hóa đơn thành công!');
            } else {
                throw new \Exception('Không thể xóa hóa đơn');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord/invoice', $e->getMessage());
        }
    }

}
?>
