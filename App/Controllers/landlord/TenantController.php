<?php
/*
	Author: Nguyen Xuan Duong
	Date: 2025-09-07
	Purpose: Build Tenant Controller
*/
namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use Core\ViewRender;
use App\Models\Tenant;
use App\Models\Room;
use Core\Session;
use Core\Request;
use Core\CSRF;
use Helpers\Validate;

class TenantController extends LandlordController
{
    private $tenantModel;
    private $roomModel;
    private $request;
    
    public function __construct()
    {
        parent::__construct();
        $this->tenantModel = new Tenant();
        $this->roomModel = new Room();
        $this->request = new Request();
    }
    
    public function index()
    {
        // Lấy user_id từ session
        $userId = Session::get('user')['id'];
        
        // Sử dụng logic chung từ LandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($userId, $this->request->get('house_id'));
        
        $tenants = [];
        $tenantsByRoom = [];
        
        $rooms = [];
        
        // Lấy danh sách khách thuê của nhà được chọn
        if ($selectedHouse) {
            $tenants = $this->tenantModel->getTenantsByHouseId($selectedHouse['id'], $userId);
            // Lấy danh sách phòng có thể thêm người
            $rooms = $this->tenantModel->getAvailableRoomsByHouseId($selectedHouse['id'], $userId);
            
            // Nhóm khách thuê theo phòng
            foreach ($tenants as $tenant) {
                $roomId = $tenant['room_id'];
                if (!isset($tenantsByRoom[$roomId])) {
                    $tenantsByRoom[$roomId] = [
                        'room_name' => $tenant['room_name'],
                        'tenants' => []
                    ];
                }
                $tenantsByRoom[$roomId]['tenants'][] = $tenant;
            }
        }
        
        // Truyền dữ liệu vào view
        ViewRender::render('landlord/tenant/index', [
            'houses' => $houses,
            'selectedHouse' => $selectedHouse,
            'tenants' => $tenants,
            'tenantsByRoom' => $tenantsByRoom,
            'rooms' => $rooms
        ]);
    }

    /**
     * Tạo mới khách hàng
     */
    public function create()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ'
            ]);
            exit;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy dữ liệu từ request
        $userData = [
            'username' => $this->request->post('username'),
            'email' => $this->request->post('email'),
            'phone' => $this->request->post('phone'),
            'gender' => $this->request->post('gender'),
            'birthday' => $this->request->post('birthday'),
            'job' => $this->request->post('job'),
            'province' => $this->request->post('province'),
            'ward' => $this->request->post('ward'),
            'address' => $this->request->post('address'),
            'citizen_id' => $this->request->post('citizen_id'),
            'role_id' => 3, // Customer role
            'account_status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $tenantData = [
            'room_id' => $this->request->post('room_id'),
            'join_date' => $this->request->post('join_date'),
            'expected_leave_date' => $this->request->post('expected_leave_date'),
            'is_primary' => $this->request->post('is_primary') ? 1 : 0,
            'note' => $this->request->post('note'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Validate dữ liệu sử dụng Validate helper
        $validationData = array_merge($userData, $tenantData);
        $validationErrors = Validate::validateTenantData($validationData, $this->tenantModel);
        
        if (!empty($validationErrors)) {
            // Trả về JSON response với lỗi
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'errors' => $validationErrors,
                'csrf_token' => CSRF::generateToken()
            ]);
            exit;
        }

        // Lấy thông tin email đã active
        $emailInfo = $this->tenantModel->checkEmailExistsAndActive($userData['email']);

        try {
            // Bắt đầu transaction
            $this->tenantModel->beginTransaction();
            
            // Sử dụng user_id có sẵn từ email đã active
            $userId = $emailInfo['id'];
            
            // Cập nhật thông tin user (nếu có thay đổi)
            $updateData = [];
            if ($userData['username'] !== $emailInfo['username']) {
                $updateData['username'] = $userData['username'];
            }
            if (!empty($userData['phone'])) {
                $updateData['phone'] = $userData['phone'];
            }
            if (!empty($userData['gender'])) {
                $updateData['gender'] = $userData['gender'];
            }
            if (!empty($userData['birthday'])) {
                $updateData['birthday'] = $userData['birthday'];
            }
            if (!empty($userData['job'])) {
                $updateData['job'] = $userData['job'];
            }
            if (!empty($userData['province'])) {
                $updateData['province'] = $userData['province'];
            }
            if (!empty($userData['ward'])) {
                $updateData['ward'] = $userData['ward'];
            }
            if (!empty($userData['address'])) {
                $updateData['address'] = $userData['address'];
            }
            if (!empty($userData['citizen_id'])) {
                $updateData['citizen_id'] = $userData['citizen_id'];
            }
            
            // Cập nhật thông tin user nếu có thay đổi
            if (!empty($updateData)) {
                $updateData['updated_at'] = date('Y-m-d H:i:s');
                $this->tenantModel->query('UPDATE users SET ' . implode(' = ?, ', array_keys($updateData)) . ' = ? WHERE id = ?', 
                    array_merge(array_values($updateData), [$userId]));
            }
            
            // Gán user vào phòng
            $tenantData['user_id'] = $userId;
            $result = $this->tenantModel->createTenant($tenantData);
            
            if ($result) {
                // Commit transaction
                $this->tenantModel->commit();
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Thêm khách hàng thành công!',
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            } else {
                // Rollback nếu có lỗi
                $this->tenantModel->rollback();
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi thêm khách hàng vào phòng',
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            }
        } catch (\Exception $e) {
            // Rollback nếu có exception
            $this->tenantModel->rollback();
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
            exit;
        }
    }

    /**
     * Lấy thông tin khách hàng để edit
     */
    public function edit($tenantId = null)
    {
        // Kiểm tra request method
        if (!$this->request->isGet()) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ'
            ]);
            exit;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];
        
        // Lấy tenant_id từ parameter hoặc request
        if (empty($tenantId)) {
            $tenantId = $this->request->get('id');
        }
        
        if (empty($tenantId)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID khách hàng không hợp lệ'
            ]);
            exit;
        }
        

        // Lấy thông tin khách hàng
        try {
            $tenant = $this->tenantModel->getTenantForEdit($tenantId, $ownerId);
            
            if (!$tenant) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy khách hàng'
                ]);
                exit;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin khách hàng: ' . $e->getMessage()
            ]);
            exit;
        }

        // Lấy danh sách phòng có thể chuyển đến
        try {
            $rooms = $this->tenantModel->getAvailableRoomsByHouseId($tenant['house_id'], $ownerId);
            
            // Thêm phòng hiện tại vào danh sách (nếu không có trong available rooms)
            $currentRoomExists = false;
            foreach ($rooms as $room) {
                if ($room['id'] == $tenant['room_id']) {
                    $currentRoomExists = true;
                    break;
                }
            }
            
            if (!$currentRoomExists) {
                $rooms[] = [
                    'id' => $tenant['room_id'],
                    'room_name' => $tenant['room_name'],
                    'room_status' => 'occupied',
                    'max_tenants' => 999, // Không giới hạn cho phòng hiện tại
                    'current_tenants' => 1
                ];
            }
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách phòng: ' . $e->getMessage()
            ]);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'tenant' => $tenant,
            'rooms' => $rooms
        ]);
        exit;
    }

    /**
     * Cập nhật thông tin khách hàng
     */
    public function update()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ'
            ]);
            exit;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy tenant_id từ request
        $tenantId = $this->request->post('tenant_id');
        
        if (empty($tenantId)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID khách hàng không hợp lệ'
            ]);
            exit;
        }

        // Kiểm tra khách hàng có tồn tại và thuộc về owner không
        $existingTenant = $this->tenantModel->getTenantForEdit($tenantId, $ownerId);
        if (!$existingTenant) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy khách hàng'
            ]);
            exit;
        }

        // Lấy dữ liệu từ request
        $userData = [
            'username' => $this->request->post('username'),
            'phone' => $this->request->post('phone'),
            'gender' => $this->request->post('gender'),
            'birthday' => $this->request->post('birthday'),
            'job' => $this->request->post('job'),
            'province' => $this->request->post('province'),
            'ward' => $this->request->post('ward'),
            'address' => $this->request->post('address'),
            'citizen_id' => $this->request->post('citizen_id')
        ];

        $tenantData = [
            'room_id' => $this->request->post('room_id'),
            'join_date' => $this->request->post('join_date'),
            'expected_leave_date' => $this->request->post('expected_leave_date'),
            'is_primary' => $this->request->post('is_primary') ? 1 : 0,
            'note' => $this->request->post('note')
        ];

        // Validate dữ liệu sử dụng Validate helper (không validate email)
        $validationData = array_merge($userData, $tenantData);
        $validationErrors = Validate::validateTenantDataForUpdate($validationData, $this->tenantModel, $tenantId);
        
        if (!empty($validationErrors)) {
            // Trả về JSON response với lỗi
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'errors' => $validationErrors,
                'csrf_token' => CSRF::generateToken()
            ]);
            exit;
        }

        try {
            // Cập nhật thông tin khách hàng
            $result = $this->tenantModel->updateTenant($tenantId, $userData, $tenantData, $ownerId);
            
            if ($result) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật thông tin khách hàng thành công!',
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            } else {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi cập nhật thông tin khách hàng',
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
            exit;
        }
    }

    /**
     * Kiểm tra thông tin khách thuê trước khi xóa
     */
    public function checkTenantBeforeRemove()
    {
        // Kiểm tra request method
        if (!$this->request->isGet()) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ'
            ]);
            exit;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy tenant_id từ request
        $tenantId = $this->request->get('tenant_id');
        
        if (empty($tenantId)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID khách thuê không hợp lệ'
            ]);
            exit;
        }

        try {
            // Kiểm tra xem khách thuê có phải là người cuối cùng trong phòng không
            $isLastTenant = $this->tenantModel->isLastTenantInRoom($tenantId, $ownerId);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'is_last_tenant' => $isLastTenant,
                'csrf_token' => CSRF::generateToken()
            ]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
            exit;
        }
    }

    /**
     * Xóa khách thuê khỏi phòng
     */
    public function removeTenant()
    {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ'
            ]);
            exit;
        }

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy tenant_id từ request
        $tenantId = $this->request->post('tenant_id');
        
        if (empty($tenantId)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'ID khách thuê không hợp lệ'
            ]);
            exit;
        }

        // Validate CSRF token
        if (!CSRF::verifyToken($this->request->post('csrf_token'))) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ]);
            exit;
        }

        try {
            // Xóa khách thuê khỏi phòng
            $result = $this->tenantModel->removeTenantFromRoom($tenantId, $ownerId);
            
            if ($result) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Xóa khách thuê khỏi phòng thành công!',
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            } else {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa khách thuê khỏi phòng',
                    'csrf_token' => CSRF::generateToken()
                ]);
                exit;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'csrf_token' => CSRF::generateToken()
            ]);
            exit;
        }
    }

}
