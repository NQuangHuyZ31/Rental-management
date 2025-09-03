<?php
/*
	Author: Nguyen Xuan Duong
	Date: 2025-08-31
	Purpose: Build Service Controller
*/
namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use Core\ViewRender;
use App\Models\Landlord\Service;
use App\Models\Landlord\Room;
use App\Models\Landlord\ServiceUsage;
use Core\Session;
use Core\Request;
use Core\CSRF;

class ServiceController extends LandlordController
{
    private $serviceModel;
    private $roomModel;
    private $serviceUsageModel;
    private $request;
    
    public function __construct()
    {
        parent::__construct();
        $this->serviceModel = new Service();
        $this->roomModel = new Room();
        $this->serviceUsageModel = new ServiceUsage();
        $this->request = new Request();
    }
    
    public function index()
    {
        // Lấy user_id từ session
        $userId = Session::get('user')['id'];
        
        // Sử dụng logic chung từ BaseLandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($userId, $this->request->get('house_id'));
        
        $services = [];
        $rooms = [];
        
        // Lấy danh sách phòng của nhà được chọn
        if ($selectedHouse) {
            $rooms = $this->roomModel->getRoomsByHouseId($selectedHouse['id']);
            
            // Lấy danh sách dịch vụ của nhà được chọn
            $services = $this->serviceModel->getServicesByHouseId($selectedHouse['id']);
            
            // Đếm số phòng áp dụng cho mỗi dịch vụ và thêm unit_vi
            foreach ($services as &$service) {
                $roomCount = $this->serviceModel->getRoomCountByServiceId($service['id']);
                $service['room_count'] = $roomCount;
                
                // Tạo unit_vi dựa trên unit
                $service['unit_vi'] = $this->getUnitVietnamese($service['unit']);
            }
        }
        
        // Truyền dữ liệu vào view
        ViewRender::render('landlord/service/index', [
            'houses' => $houses,
            'selectedHouse' => $selectedHouse,
            'services' => $services,
            'rooms' => $rooms
        ]);
    }

    /**
     * Tạo mới dịch vụ
     */
    public function create()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord/service', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord/service', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy dữ liệu từ request
        $unit = $this->request->post('unit');
        $serviceData = [
            'house_id' => $this->request->post('house_id'),
            'service_name' => $this->request->post('service_name'),
            'service_price' => $this->request->post('service_price'),
            'service_type' => $this->request->post('service_type'),
            'unit' => $unit,
            'unit_vi' => $this->getUnitVietnamese($unit),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Lấy danh sách phòng được chọn
        $selectedRooms = $this->request->post('rooms') ?? [];

        // Validate dữ liệu
        if (empty($serviceData['house_id']) || empty($serviceData['service_name']) || 
            empty($serviceData['service_price']) || empty($serviceData['service_type']) || 
            empty($serviceData['unit']) || empty($selectedRooms)) {
            $this->request->redirectWithError('/landlord/service', 'Vui lòng điền đầy đủ thông tin bắt buộc và chọn ít nhất một phòng');
            return;
        }

        // Kiểm tra unit có hợp lệ không
        if (!$this->isValidUnit($unit)) {
            $this->request->redirectWithError('/landlord/service', 'Đơn vị không hợp lệ. Chỉ chấp nhận: KWH, m3, month, person');
            return;
        }

        try {
            // Bắt đầu transaction
            $this->serviceModel->beginTransaction();
            
            // Tạo dịch vụ mới
            $serviceId = $this->serviceModel->createService($serviceData);
            
            if ($serviceId) {
                // Gán dịch vụ cho các phòng được chọn
                foreach ($selectedRooms as $roomId) {
                    $this->serviceModel->assignServiceToRoom($roomId, $serviceId);
                }
                
                // Commit transaction
                $this->serviceModel->commit();
                $this->request->redirectWithSuccess('/landlord/service', 'Tạo dịch vụ thành công!');
            } else {
                // Rollback nếu có lỗi
                $this->serviceModel->rollback();
                $this->request->redirectWithError('/landlord/service', 'Có lỗi xảy ra khi tạo dịch vụ');
            }
        } catch (\Exception $e) {
            // Rollback nếu có exception
            $this->serviceModel->rollback();
            $this->request->redirectWithError('/landlord/service', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật dịch vụ
     */
    public function update()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord/service', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord/service', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy dữ liệu từ request
        $serviceId = $this->request->post('service_id');
        $unit = $this->request->post('unit');
        $serviceData = [
            'service_name' => $this->request->post('service_name'),
            'service_price' => $this->request->post('service_price'),
            'service_type' => $this->request->post('service_type'),
            'unit' => $unit,
            'unit_vi' => $this->getUnitVietnamese($unit),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Lấy danh sách phòng được chọn
        $selectedRooms = $this->request->post('rooms') ?? [];

        // Validate dữ liệu
        if (empty($serviceId) || empty($serviceData['service_name']) || 
            empty($serviceData['service_price']) || empty($serviceData['service_type']) || 
            empty($serviceData['unit']) || empty($selectedRooms)) {
            $this->request->redirectWithError('/landlord/service', 'Vui lòng điền đầy đủ thông tin bắt buộc và chọn ít nhất một phòng');
            return;
        }

        // Kiểm tra unit có hợp lệ không
        if (!$this->isValidUnit($unit)) {
            $this->request->redirectWithError('/landlord/service', 'Đơn vị không hợp lệ. Chỉ chấp nhận: KWH, m3, month, person');
            return;
        }

        try {
            // Bắt đầu transaction
            $this->serviceModel->beginTransaction();
            
            // Cập nhật dịch vụ
            $result = $this->serviceModel->updateService($serviceId, $serviceData);
            
            if ($result) {
                // Xóa tất cả phòng cũ của dịch vụ
                $this->serviceModel->removeAllRoomsFromService($serviceId);
                
                // Gán dịch vụ cho các phòng mới được chọn
                foreach ($selectedRooms as $roomId) {
                    $this->serviceModel->assignServiceToRoom($roomId, $serviceId);
                }
                
                // Commit transaction
                $this->serviceModel->commit();
                $this->request->redirectWithSuccess('/landlord/service', 'Cập nhật dịch vụ thành công!');
            } else {
                // Rollback nếu có lỗi
                $this->serviceModel->rollback();
                $this->request->redirectWithError('/landlord/service', 'Có lỗi xảy ra khi cập nhật dịch vụ');
            }
        } catch (\Exception $e) {
            // Rollback nếu có exception
            $this->serviceModel->rollback();
            $this->request->redirectWithError('/landlord/service', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Lấy danh sách phòng của dịch vụ
     */
    public function getServiceRooms($serviceId)
    {
        // Kiểm tra request method
        if (!$this->request->isGet()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            return;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        try {
            // Lấy danh sách phòng của dịch vụ
            $rooms = $this->serviceModel->getRoomsByServiceId($serviceId, $ownerId);

            if ($rooms !== false) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'rooms' => $rooms
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy dịch vụ hoặc bạn không có quyền truy cập'
                ]);
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Chuyển đổi unit sang tiếng Việt
     */
    private function getUnitVietnamese($unit)
    {
        $unitMap = [
            'KWH' => 'kWh',
            'm3' => 'm³',
            'month' => 'tháng',
            'person' => 'người'
        ];
        
        return $unitMap[$unit] ?? $unit;
    }

    /**
     * Kiểm tra unit có hợp lệ không
     */
    private function isValidUnit($unit)
    {
        $validUnits = ['KWH', 'm3', 'month', 'person'];
        return in_array($unit, $validUnits);
    }

    /**
     * Lấy dữ liệu sử dụng dịch vụ theo tháng (API)
     */
    public function getUsageByMonth()
    {
        // Kiểm tra request method
        if (!$this->request->isGet()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            return;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy tham số từ request
        $houseId = $this->request->get('house_id');
        $month = $this->request->get('month');
        $year = $this->request->get('year');

        // Validate tham số
        if (empty($houseId) || empty($month) || empty($year)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin house_id, month hoặc year']);
            return;
        }

        try {
            // Debug logging
            error_log("ServiceController::getUsageByMonth - houseId: $houseId, month: $month, year: $year");
            
            // Lấy dữ liệu sử dụng theo tháng
            $usageData = $this->serviceUsageModel->getUsageByMonthAndHouse($houseId, $month, $year);
            
            // Debug logging
            error_log("ServiceController::getUsageByMonth - usageData: " . json_encode($usageData));
            
            if ($usageData !== false) {
                if (empty($usageData)) {
                    // Không có dữ liệu sử dụng cho tháng này
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'data' => [],
                        'message' => 'Không có dữ liệu sử dụng cho tháng ' . $month . '/' . $year
                    ]);
                    return;
                }
                
                // Xử lý dữ liệu để hiển thị theo format mong muốn
                $processedData = $this->processUsageDataForDisplay($usageData);
                
                // Debug logging
                error_log("ServiceController::getUsageByMonth - processedData: " . json_encode($processedData));
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'data' => $processedData
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Không thể lấy dữ liệu sử dụng'
                ]);
            }
        } catch (\Exception $e) {
            error_log("ServiceController::getUsageByMonth - Exception: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Xử lý dữ liệu sử dụng để hiển thị trong bảng
     */
    private function processUsageDataForDisplay($usageData)
    {
        $rooms = [];
        
        foreach ($usageData as $row) {
            $roomId = $row['room_id'];
            $serviceType = $row['service_type'];
            
            if (!isset($rooms[$roomId])) {
                $rooms[$roomId] = [
                    'room_id' => $roomId,
                    'room_number' => $row['room_number'],
                    'services' => []
                ];
            }
            
            // Thêm thông tin dịch vụ
            $rooms[$roomId]['services'][$serviceType] = [
                'service_name' => $row['service_name'],
                'usage_amount' => $row['usage_amount'],
                'total_amount' => $row['total_amount'],
                'unit' => $row['unit'],
                'unit_vi' => $row['unit_vi']
            ];
        }
        
        return array_values($rooms);
    }
}