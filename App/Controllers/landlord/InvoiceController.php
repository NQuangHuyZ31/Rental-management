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
        
        // Lấy tháng và năm hiện tại (mặc định là tháng trước)
        $currentMonth = date('n');
        $currentYear = date('Y');
        $selectedMonth = $this->request->get('month', $currentMonth - 1);
        $selectedYear = $this->request->get('year', $currentYear);
        
        // Xử lý tháng trước nếu tháng hiện tại là 1
        if ($selectedMonth <= 0) {
            $selectedMonth = 12;
            $selectedYear = $currentYear - 1;
        }
        
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
     * API lấy hóa đơn theo tháng/năm (AJAX)
     */
    public function getInvoicesByMonth()
    {
        try {
            $userId = Session::get('user')['id'];
            
            // Get JSON input
            $rawInput = file_get_contents('php://input');
            error_log("InvoiceController::getInvoicesByMonth - Raw input: " . $rawInput);
            
            $input = json_decode($rawInput, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Dữ liệu JSON không hợp lệ: ' . json_last_error_msg());
            }
            
            $month = $input['month'] ?? null;
            $year = $input['year'] ?? null;
            $houseId = $input['house_id'] ?? null;
            
            // Sử dụng cùng logic như method index() để lấy selectedHouseId
            // Nếu houseId từ request là null, sử dụng houseId từ session hoặc mặc định
            if (!$houseId) {
                $houseId = Session::get('selected_house_id');
            }
            [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($userId, $houseId);
            
            // Debug: Log the received data
            error_log("InvoiceController::getInvoicesByMonth - User ID: $userId, Month: $month, Year: $year, House ID: $houseId, Selected House ID: $selectedHouseId");
            error_log("InvoiceController::getInvoicesByMonth - Selected House: " . json_encode($selectedHouse));
            
            if (!$month || !$year) {
                throw new \Exception('Tháng và năm không hợp lệ');
            }
            
            // Sử dụng selectedHouseId thay vì houseId để đảm bảo nhất quán
            $invoices = $this->invoiceModel->getInvoicesForTable($userId, $month, $year, $selectedHouseId);
            $stats = $this->invoiceModel->getMonthlyInvoiceSummary($userId, $month, $year, $selectedHouseId);
            
            // Debug: Log the query parameters
            error_log("InvoiceController::getInvoicesByMonth - Query params: userId=$userId, month=$month, year=$year, selectedHouseId=$selectedHouseId");
            
            // Debug: Log the results
            error_log("InvoiceController::getInvoicesByMonth - Found " . count($invoices) . " invoices");
            
            echo json_encode([
                'success' => true,
                'invoices' => $invoices,
                'stats' => $stats,
                'csrf_token' => CSRF::generateToken()
            ]);
        } catch (\Exception $e) {
            error_log("InvoiceController::getInvoicesByMonth - Error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
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
     * Lấy danh sách phòng đang cho thuê
     */
    public function getRentedRooms()
    {
        try {
            $userId = Session::get('user')['id'];
            $houseId = $this->request->get('house_id');
            
            // Sử dụng logic chung từ LandlordController
            [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($userId, $houseId);
            
            $rooms = $this->invoiceModel->getRentedRooms($userId, $selectedHouseId);
            
            echo json_encode([
                'success' => true,
                'rooms' => $rooms,
                'csrf_token' => CSRF::generateToken()
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
    }
    
    /**
     * Lấy danh sách dịch vụ theo phòng
     */
    public function getRoomServices()
    {
        try {
            $userId = Session::get('user')['id'];
            $roomId = $this->request->get('room_id');
            
            if (!$roomId) {
                throw new \Exception('ID phòng không hợp lệ');
            }
            
            $services = $this->invoiceModel->getRoomServices($roomId, $userId);
            
            echo json_encode([
                'success' => true,
                'services' => $services,
                'csrf_token' => CSRF::generateToken()
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
        }
    }
}
?>
