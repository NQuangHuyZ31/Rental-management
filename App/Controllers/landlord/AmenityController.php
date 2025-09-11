<?php
/*
	Author: Nguyen Xuan Duong
	Date: 2025-09-05
	Purpose: Build Amenity Controller
*/
namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use Core\ViewRender;
use App\Models\Landlord\Amenity;
use App\Models\Landlord\Room;
use Core\Session;
use Core\Request;
use Core\CSRF;

class AmenityController extends LandlordController
{
    private $amenityModel;
    private $roomModel;
    private $request;
    
    public function __construct()
    {
        parent::__construct();
        $this->amenityModel = new Amenity();
        $this->roomModel = new Room();
        $this->request = new Request();
    }
    
    public function index()
    {
        // Lấy user_id từ session
        $userId = Session::get('user')['id'];
        
        // Sử dụng logic chung từ LandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($userId, $this->request->get('house_id'));
        
        $amenities = [];
        $rooms = [];
        
        // Lấy danh sách phòng của nhà được chọn
        if ($selectedHouse) {
            $rooms = $this->roomModel->getRoomsByHouseId($selectedHouse['id']);
            
            // Lấy danh sách tài sản của nhà được chọn
            $amenities = $this->amenityModel->getAmenitiesByHouseId($selectedHouse['id']);
            
            // Lấy thông tin phòng và kiểm tra quyền xóa cho mỗi tài sản
            foreach ($amenities as &$amenity) {
                // Lấy danh sách phòng đang áp dụng tài sản
                $usedRooms = $this->amenityModel->getUsedRoomsByAmenityId($amenity['id'], $selectedHouse['id']);
                $amenity['used_rooms'] = $usedRooms;
                
                // Kiểm tra có thể xóa tài sản không
                $canDeleteResult = $this->amenityModel->canDeleteAmenity($amenity['id'], $userId);
                $amenity['can_delete'] = $canDeleteResult['can_delete'];
                $amenity['delete_reason'] = $canDeleteResult['reason'];
            }
        }
        
        // Lấy các giá trị enum cho đơn vị
        $unitOptions = $this->getUnitOptions();
        
        // Truyền dữ liệu vào view
        ViewRender::render('landlord/amenity/index', [
            'houses' => $houses,
            'selectedHouse' => $selectedHouse,
            'amenities' => $amenities,
            'rooms' => $rooms,
            'unitOptions' => $unitOptions
        ]);
    }

    /**
     * Tạo mới tài sản
     */
    public function create()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord/amenity', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord/amenity', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy dữ liệu từ request
        $amenityData = [
            'house_id' => $this->request->post('house_id'),
            'amenity_name' => $this->request->post('amenity_name'),
            'amenity_price' => $this->request->post('amenity_price'),
            'quantity' => $this->request->post('quantity'),
            'unit' => $this->request->post('unit'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Lấy danh sách phòng được chọn
        $selectedRooms = $this->request->post('rooms') ?? [];

        // Validate dữ liệu
        if (empty($amenityData['house_id']) || empty($amenityData['amenity_name']) || 
            empty($amenityData['amenity_price']) || empty($amenityData['quantity']) || 
            empty($amenityData['unit'])) {
            $this->request->redirectWithError('/landlord/amenity', 'Vui lòng điền đầy đủ thông tin bắt buộc');
            return;
        }

        try {
            // Bắt đầu transaction
            $this->amenityModel->beginTransaction();
            
            // Tạo tài sản mới
            $amenityId = $this->amenityModel->createAmenity($amenityData);
            
            if ($amenityId) {
                // Gán tài sản cho các phòng được chọn (nếu có)
                if (!empty($selectedRooms)) {
                    foreach ($selectedRooms as $roomId) {
                        $this->amenityModel->assignAmenityToRoom($roomId, $amenityId);
                    }
                }
                
                // Commit transaction
                $this->amenityModel->commit();
                $this->request->redirectWithSuccess('/landlord/amenity', 'Tạo tài sản thành công!');
            } else {
                // Rollback nếu có lỗi
                $this->amenityModel->rollback();
                $this->request->redirectWithError('/landlord/amenity', 'Có lỗi xảy ra khi tạo tài sản');
            }
        } catch (\Exception $e) {
            // Rollback nếu có exception
            $this->amenityModel->rollback();
            $this->request->redirectWithError('/landlord/amenity', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật tài sản
     */
    public function update()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord/amenity', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord/amenity', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy dữ liệu từ request
        $amenityId = $this->request->post('amenity_id');
        $amenityData = [
            'amenity_name' => $this->request->post('amenity_name'),
            'amenity_price' => $this->request->post('amenity_price'),
            'quantity' => $this->request->post('quantity'),
            'unit' => $this->request->post('unit'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Lấy danh sách phòng được chọn
        $selectedRooms = $this->request->post('rooms') ?? [];

        // Validate dữ liệu
        if (empty($amenityId) || empty($amenityData['amenity_name']) || 
            empty($amenityData['amenity_price']) || empty($amenityData['quantity']) || 
            empty($amenityData['unit'])) {
            $this->request->redirectWithError('/landlord/amenity', 'Vui lòng điền đầy đủ thông tin bắt buộc');
            return;
        }

        try {
            // Bắt đầu transaction
            $this->amenityModel->beginTransaction();
            
            // Cập nhật tài sản
            $result = $this->amenityModel->updateAmenity($amenityId, $amenityData);
            
            if ($result) {
                // Xóa tất cả phòng cũ của tài sản
                $this->amenityModel->removeAllRoomsFromAmenity($amenityId);
                
                // Gán tài sản cho các phòng mới được chọn (nếu có)
                if (!empty($selectedRooms)) {
                    foreach ($selectedRooms as $roomId) {
                        $this->amenityModel->assignAmenityToRoom($roomId, $amenityId);
                    }
                }
                
                // Commit transaction
                $this->amenityModel->commit();
                $this->request->redirectWithSuccess('/landlord/amenity', 'Cập nhật tài sản thành công!');
            } else {
                // Rollback nếu có lỗi
                $this->amenityModel->rollback();
                $this->request->redirectWithError('/landlord/amenity', 'Có lỗi xảy ra khi cập nhật tài sản');
            }
        } catch (\Exception $e) {
            // Rollback nếu có exception
            $this->amenityModel->rollback();
            $this->request->redirectWithError('/landlord/amenity', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Lấy danh sách phòng của tài sản
     */
    public function getAmenityRooms($amenityId)
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
            // Lấy danh sách phòng của tài sản
            $rooms = $this->amenityModel->getRoomsByAmenityId($amenityId, $ownerId);

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
                    'message' => 'Không tìm thấy tài sản hoặc bạn không có quyền truy cập'
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
     * Xóa tài sản
     */
    public function delete()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord/amenity', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord/amenity', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy amenity_id từ request
        $amenityId = $this->request->post('amenity_id');

        // Validate dữ liệu
        if (empty($amenityId)) {
            $this->request->redirectWithError('/landlord/amenity', 'Thiếu thông tin tài sản cần xóa');
            return;
        }

        try {
            // Xóa tài sản
            $result = $this->amenityModel->deleteAmenity($amenityId, $ownerId);
            
            if ($result['success']) {
                $this->request->redirectWithSuccess('/landlord/amenity', $result['message']);
            } else {
                $this->request->redirectWithError('/landlord/amenity', $result['message']);
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord/amenity', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Lấy danh sách các giá trị enum cho đơn vị
     */
    private function getUnitOptions()
    {
        try {
            // Lấy các giá trị enum từ database
            $result = $this->amenityModel->query("SHOW COLUMNS FROM amenities LIKE 'unit'");
            $columnInfo = $result->fetch();
            
            if ($columnInfo && strpos($columnInfo['Type'], 'enum') !== false) {
                // Parse enum values
                preg_match_all("/'([^']+)'/", $columnInfo['Type'], $matches);
                return $matches[1];
            }
            
            // Fallback nếu không phải enum
            return ['cái', 'bộ', 'chiếc', 'cặp'];
        } catch (\Exception $e) {
            // Fallback nếu có lỗi
            return ['cái', 'bộ', 'chiếc', 'cặp'];
        }
    }
}

