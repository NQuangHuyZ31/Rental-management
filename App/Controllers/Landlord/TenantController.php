<?php
/*
Author: Nguyen Xuan Duong
Date: 2025-09-07
Purpose: Build Tenant Controller
 */
namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use App\Requests\AddTenantValidate;
use Core\CSRF;
use Core\Response;
use Core\Session;
use Core\ViewRender;
use Helpers\Hash;
use Queue\SendEmailResetPassword;

class TenantController extends LandlordController {

    protected $sendEmailResetPasswordJob;

    public function __construct() {
        parent::__construct();
        $this->sendEmailResetPasswordJob = new SendEmailResetPassword();
    }

    public function index() {
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
                        'tenants' => [],
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
            'rooms' => $rooms,
        ]);
    }

    // Added by Huy Nguyen on 2025-10-31 to find customer for email
    public function find() {
        $requests = $this->request->post();

        if (!isset($requests['email']) || (isset($requests['email']) && !preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $requests['email']))) {
            Response::json(['status' => 'error', 'msg' => 'Email không đúng định dạng', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi khi tìm kiếm. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $customer = $this->userModel->getUserByEmail($requests['email']);

        Response::json(['status' => 'success', 'data' => $customer, 'token' => CSRF::getTokenRefresh()], 200);
    }

    // Modify by Huy Nguyen on 2024-11-1 to refactor handle logic
    public function create() {
        $requests = $this->request->post();

        if (empty($requests['room_id'])) {
            Response::json(['status' => 'error', 'msg' => 'Phòng này không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (empty($requests['tenant_id']) && $requests['is_create'] == 0) {
            Response::json(['status' => 'error', 'msg' => 'Chưa có khách hàng nào được chọn', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Dữ liệu không hợp lệ', 'token' => CSRF::getTokenRefresh()], 400);
        }

        // Kiểm tra lại lần cuối khách thuê đã được thêm vào phòng chưa
        if (!empty($requests['tenant_id']) && $this->tenantModel->getByTenantAndRoom($requests['tenant_id'], $requests['room_id'])) {
            Response::json(['status' => 'error', 'msg' => 'Khách thuê đã tồn tại trong phòng', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if ($requests['is_create'] == 0 && !$this->userModel->getUserById($requests['tenant_id'])) {
            Response::json(['status' => 'error', 'msg' => 'Khách hàng không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $error = AddTenantValidate::validate($requests);

        if (!empty($error)) {
            Response::json(['status' => 'error', 'msg' => $error, 'token' => CSRF::getTokenRefresh()], 400);
        }

        // Kiểm tra xem khách trong phòng đã đầy chưa
        $room = $this->roomModel->getRoomById($requests['room_id']);

        if (!$room || $room['max_people'] <= $room['stay_in']) {
            Response::json(['status' => 'error', 'msg' => 'Phòng đã đầy, không thể thêm khách thuê mới', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if ($requests['is_create'] == 1) {
            $tenantId = $this->createAccountForTenant($requests);

            if (!$tenantId) {
                Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra khi tạo khách hàng mới', 'token' => CSRF::getTokenRefresh()], 500);
            }

            $requests['tenant_id'] = $tenantId;
        }

        // Thêm khách thuê vào phòng
        $addTenantResult = $this->tenantModel->add(
            ['room_id' => $requests['room_id'], 'user_id' => $requests['tenant_id'], 'join_date' => $requests['join_date'], 'is_primary' => $requests['is_primary'] ?? 0,
                'note' => $requests['note'] ?? '', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

        if (!$addTenantResult) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra khi thêm khách thuê vào phòng', 'token' => CSRF::getTokenRefresh()], 500);
        }

        // Update citizen_id trong bảng users
        $this->userModel->updateColumn($requests['tenant_id'], 'citizen_id', $requests['citizen_id']);
        // Cập nhật số người ở hiện tại trong phòng
        $this->roomModel->updateColumn($requests['room_id'], 'stay_in', $room['stay_in'] + 1);

        if ($this->roomModel->getColumn(['stay_in'], 'rooms', $requests['room_id']) > 0) {
            $this->roomModel->updateColumn($requests['room_id'], 'room_status', 'occupied');
        }

        Response::json(['status' => 'success', 'msg' => 'Thêm khách thuê thành công', 'token' => CSRF::getTokenRefresh()], 200);
    }

    // Added by Huy Nguyen on 2025-11-03 to create acccount
    private function createAccountForTenant($requests) {
        $dataUser = ['email' => $requests['email'], 'username' => $requests['username']];

        $dataEncrypted = Hash::encrypt(json_encode($dataUser));

        $resetUrl = APP_URL . '/reset-password?token=' . $dataEncrypted . '&verify_account=1';
        $this->sendEmailResetPasswordJob->dispatchHigh([
            'to' => $requests['email'],
            'customer' => $requests['username'],
            'resetUrl' => $resetUrl,
            'activeAccount' => true,
        ]);

        // Tạo mới khách hàng
        $newUserData = [
            'username' => $requests['username'],
            'email' => $requests['email'],
            'password' => password_hash('hosty@123456', PASSWORD_DEFAULT),
            'phone' => $requests['phone'],
            'gender' => $requests['gender'] ?? '',
            'birthday' => $requests['birthday'] ?? null,
            'job' => $requests['job'] ?? '',
            'province' => $requests['province'] ?? '',
            'ward' => $requests['ward'] ?? '',
            'address' => $requests['address'] ?? '',
            'citizen_id' => $requests['citizen_id'] ?? '',
            'role_id' => 3, // role_id cho khách thuê
            'account_status' => 'inactive', // Mặc định tài khoản chưa kích hoạt
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $tenantId = $this->userModel->insertUser($newUserData);

        return $tenantId;
    }

    // Modify by Huy Nguyen on 2025-11-1 to refactor handle show info customer rental
    public function edit() {
        // Lấy thông tin tenant từ request
        $requests = $this->request->get();
        // Lấy thông tin khách thuê
        $user = $this->userModel->getUserById($requests['tenant_id']);

        if (!$user) {
            Response::json(['status' => 'error', 'msg' => 'Khách thuê không tồn tại'], 400);
        }

        // Lấy thông tin thuê phòng
        $room = $this->tenantModel->getByTenantAndRoom($requests['tenant_id'], $requests['room_id']);
        $additionalInfo = $this->tenantModel->getRoomDetailById($room['room_id']);
        $room = array_merge($room, $additionalInfo);

        if (!$room) {
            Response::json(['status' => 'error', 'msg' => 'Khách thuê không thuộc phòng này'], 400);
        }

        Response::json(['status' => 'success', 'data' => ['user' => $user, 'room' => $room]], 200);
    }

    // Modify by Huy Nguyen on 2025-11-1 to refactor handle update info customer rental
    public function update() {
        $requests = $this->request->post();

        if (empty($requests['tenant_id']) || empty($requests['room_id'])) {
            Response::json(['status' => 'error', 'msg' => 'Dữ liệu không hợp lệ', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Dữ liệu không hợp lệ', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if ($this->userModel->getUserByCitizenId($requests['citizen_id'], $requests['tenant_id'])) {
            Response::json(['status' => 'error', 'msg' => 'Căn cước công dân đã tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        $error = AddTenantValidate::validate($requests, false);

        if (!empty($error)) {
            Response::json(['status' => 'error', 'msg' => $error, 'token' => CSRF::getTokenRefresh()], 400);
        }
        // Cập nhật thông tin khách thuê
        $tenantRoom = $this->tenantModel->getByTenantAndRoom($requests['tenant_id'], $requests['room_id']);

        if (!$tenantRoom) {
            Response::json(['status' => 'error', 'msg' => 'Khách thuê không thuộc phòng này', 'token' => CSRF::getTokenRefresh()], 400);
        }

        // Cập nhật thông tin khách thuê
        $this->userModel->updateColumn($requests['tenant_id'], 'citizen_id', $requests['citizen_id']);
        $this->tenantModel->updateTable($tenantRoom['id'], [
            'join_date' => $requests['join_date'],
            'is_primary' => $requests['is_primary'] ?? 0,
            'note' => $requests['note'] ?? '',
        ]);

        Response::json(['status' => 'success', 'msg' => 'Cập nhật thông tin khách thuê thành công', 'token' => CSRF::getTokenRefresh()], 200);
    }

    /**
     * Kiểm tra thông tin khách thuê trước khi xóa
     */
    public function checkTenantBeforeRemove() {
        // Kiểm tra request method
        if (!$this->request->isGet()) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ',
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
                'message' => 'ID khách thuê không hợp lệ',
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
                'csrf_token' => CSRF::generateToken(),
            ]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'csrf_token' => CSRF::generateToken(),
            ]);
            exit;
        }
    }

    /**
     * Xóa khách thuê khỏi phòng
     */
    public function removeTenant() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ',
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
                'message' => 'ID khách thuê không hợp lệ',
            ]);
            exit;
        }

        // Validate CSRF token
        if (!CSRF::verifyToken($this->request->post('csrf_token'))) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
            ]);
            exit;
        }

        try {
            // // Xóa khách thuê khỏi phòng
            $result = $this->tenantModel->removeTenantFromRoom($tenantId, $ownerId);

            // Added by Huy Nguyen on 2025-11-04 to update stay_in when remove last tenant
            $room = $this->roomModel->getRoomById($this->request->post('room_id'));

            if ($room['stay_in'] > 0) {
                $this->roomModel->updateColumn($this->request->post('room_id'), 'stay_in', max(0, $room['stay_in'] - 1));
            }

            if ($result) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Xóa khách thuê khỏi phòng thành công!',
                    'csrf_token' => CSRF::generateToken(),
                ]);
                exit;
            } else {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa khách thuê khỏi phòng',
                    'csrf_token' => CSRF::generateToken(),
                ]);
                exit;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'csrf_token' => CSRF::generateToken(),
            ]);
            exit;
        }
    }

}
