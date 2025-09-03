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
use Core\Session;
use Core\Request;
use Core\CSRF;

class ServiceController extends LandlordController
{
    private $serviceModel;
    private $roomModel;
    private $request;
    
    public function __construct()
    {
        parent::__construct();
        $this->serviceModel = new Service();
        $this->roomModel = new Room();
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
            
            // Đếm số phòng áp dụng cho mỗi dịch vụ
            foreach ($services as &$service) {
                $roomCount = $this->serviceModel->getRoomCountByServiceId($service['id']);
                $service['room_count'] = $roomCount;
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
        $serviceData = [
            'house_id' => $this->request->post('house_id'),
            'service_name' => $this->request->post('service_name'),
            'service_price' => $this->request->post('service_price'),
            'service_type' => $this->request->post('service_type'),
            'unit' => $this->request->post('unit'),
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
}