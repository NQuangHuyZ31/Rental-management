<?php

/*
    Author: Nguyen Xuan Duong
    Date: 2025-09-12
    Purpose: Build Invoice Controller
*/

namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;    
use Core\ViewRender;
use Core\Session;
use Core\Request;
use Core\CSRF;

use App\Models\Invoice;
use Helpers\Validate;

class InvoiceController extends LandlordController{
    private $invoiceModel;
    private $request;

    public function __construct()
    {
        parent::__construct();
        $this->invoiceModel = new Invoice();
        $this->request = new Request();
    }

    public function index()
    {
        // Lấy user_id từ session
        $userId = Session::get('user')['id'];
        
        // Sử dụng logic chung từ LandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($userId, $this->request->get('house_id'));
        
        // Lấy tháng và năm hiện tại (mặc định là tháng hiện tại)
        $currentMonth = date('n');
        $currentYear = date('Y');
        $selectedMonth = $this->request->get('month', $currentMonth);
        $selectedYear = $this->request->get('year', $currentYear);
        
        // Lấy danh sách hóa đơn theo tháng/năm
        $invoices = $this->invoiceModel->getInvoicesForTable($userId, $selectedMonth, $selectedYear, $selectedHouseId);
        
        // Lấy thống kê hóa đơn
        $stats = $this->invoiceModel->getMonthlyInvoiceSummary($userId, $selectedMonth, $selectedYear, $selectedHouseId);
        
        ViewRender::render('landlord/invoice/index', [
            'selectedHouse' => $selectedHouse,
            'houses' => $houses,
            'selectedHouseId' => $selectedHouseId,
            'invoices' => $invoices,
            'stats' => $stats,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear
        ]);
    }
    
    /**
     * Lấy chi tiết hóa đơn để hiển thị modal
     */
    public function viewInvoice($invoiceId = null)
    {
        // Đảm bảo không có output trước JSON
        if (ob_get_level()) {
            ob_clean();
        }
        
        // Set header để đảm bảo trả về JSON
        header('Content-Type: application/json');
        
        try {
            $userId = Session::get('user')['id'];
            
            // Nếu không có $invoiceId từ parameter, thử lấy từ request
            if (!$invoiceId) {
                $invoiceId = $this->request->get('id');
            }
            
            if (!$invoiceId || !is_numeric($invoiceId)) {
                throw new \Exception('ID hóa đơn không hợp lệ');
            }
            
            // Lấy chi tiết hóa đơn
            $invoice = $this->invoiceModel->getInvoiceForDisplay($invoiceId, $userId);
            
            if (!$invoice) {
                throw new \Exception('Không tìm thấy hóa đơn');
            }
            
            // Lấy danh sách dịch vụ chi tiết
            $serviceDetails = $this->invoiceModel->getInvoiceServiceDetails($invoiceId, $userId);
            
            echo json_encode([
                'success' => true,
                'invoice' => $invoice,
                'serviceDetails' => $serviceDetails ?: [],
                'csrf_token' => CSRF::generateToken()
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
        
        exit; // Đảm bảo không có output nào khác
    }
    
    /**
     * Cập nhật trạng thái hóa đơn
     */
    public function updateStatus()
    {
        try {
            $userId = Session::get('user')['id'];
            $invoiceId = $this->request->post('invoice_id');
            $status = $this->request->post('status');
            
            if (!$invoiceId || !$status) {
                throw new \Exception('Dữ liệu không hợp lệ');
            }
            
            $validStatuses = ['pending', 'paid', 'overdue'];
            if (!in_array($status, $validStatuses)) {
                throw new \Exception('Trạng thái không hợp lệ');
            }
            
            $result = $this->invoiceModel->updateInvoiceStatus($invoiceId, $status, $userId);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật trạng thái thành công',
                    'csrf_token' => CSRF::generateToken()
                ]);
            } else {
                throw new \Exception('Không thể cập nhật trạng thái');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
    }
    
    /**
     * Cập nhật thông tin hóa đơn
     */
    public function update()
    {
        // Đảm bảo không có output trước JSON
        if (ob_get_level()) {
            ob_clean();
        }
        
        // Set header để đảm bảo trả về JSON
        header('Content-Type: application/json');
        
        try {
            $userId = Session::get('user')['id'];
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
                'services' => $this->request->post('services') ?: []
            ];
            
            // Validate dữ liệu sử dụng Helper Validate
            $errors = Validate::validateInvoiceData($data);
            if (!empty($errors)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $errors,
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            }
            
            // Cập nhật hóa đơn
            $result = $this->invoiceModel->updateInvoice($invoiceId, $data, $userId);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật hóa đơn thành công',
                    'csrf_token' => CSRF::generateToken()
                ]);
            } else {
                throw new \Exception('Không thể cập nhật hóa đơn');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
        
        exit; // Đảm bảo không có output nào khác
    }
    
    /**
     * Lấy form tạo hóa đơn với danh sách dịch vụ của phòng
     */
    public function createForm($roomId = null)
    {
        // Đảm bảo không có output trước JSON
        if (ob_get_level()) {
            ob_clean();
        }
        
        // Set header để đảm bảo trả về JSON
        header('Content-Type: application/json');
        
        try {
            $userId = Session::get('user')['id'];
            
            // Nếu không có $roomId từ parameter, thử lấy từ request
            if (!$roomId) {
                $roomId = $this->request->get('id');
            }
            
            if (!$roomId || !is_numeric($roomId)) {
                throw new \Exception('ID phòng không hợp lệ');
            }
            
            // Lấy thông tin phòng
            $roomModel = new \App\Models\Room();
            $room = $roomModel->getRoomById($roomId, $userId);
            
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
                'csrf_token' => CSRF::generateToken()
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
        
        exit; // Đảm bảo không có output nào khác
    }
    
    /**
     * Tạo hóa đơn mới
     */
    public function create()
    {
        // Đảm bảo không có output trước JSON
        if (ob_get_level()) {
            ob_clean();
        }
        
        // Set header để đảm bảo trả về JSON
        header('Content-Type: application/json');
        
        try {
            $userId = Session::get('user')['id'];
            
            // Validate CSRF token
            if (!CSRF::verifyToken($this->request->post('csrf_token'))) {
                throw new \Exception('Dữ liệu không hợp lệ');
            }
            
            // Lấy dữ liệu từ form
            $data = [
                'room_id' => $this->request->post('room_id'),
                'invoice_name' => $this->request->post('invoice_name'),
                'invoice_month' => $this->request->post('invoice_month'),
                'invoice_day' => $this->request->post('invoice_day'),
                'due_date' => $this->request->post('due_date'),
                'rental_amount' => $this->request->post('rental_amount'),
                'note' => $this->request->post('note'),
                'services' => $this->request->post('services') ?: []
            ];
            
            // Validate dữ liệu sử dụng Helper Validate
            $errors = Validate::validateCreateInvoiceData($data);
            if (!empty($errors)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $errors,
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            }
            
            // Tạo hóa đơn
            $result = $this->invoiceModel->createInvoice($data, $userId);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Tạo hóa đơn thành công',
                    'csrf_token' => CSRF::generateToken()
                ]);
            } else {
                throw new \Exception('Không thể tạo hóa đơn');
            }
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
        
        exit; // Đảm bảo không có output nào khác
    }
    
}
?>
