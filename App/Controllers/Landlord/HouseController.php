<?php

/*
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Build House Controller
 */

namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use Core\CSRF;
use Core\Response;
use Core\Session;
use Core\ViewRender;

class HouseController extends LandlordController {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Hiển thị trang chủ landlord
     */
    public function index() {
        $totalAmenities = 0;
        $totalServices = 0;
        // Sử dụng logic chung từ BaseLandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($this->user['id'], $this->request->get('house_id'));

        $rooms = [];
        $roomStats = [];

        // Lấy danh sách phòng của nhà trọ được chọn với phân trang
        if ($selectedHouse) {
            // page param
            $page = (int) ($this->request->get('page') ?? 1);
            if ($page < 1) $page = 1;
            $limit = $this->limit ?? 10;
            $offset = ($page - 1) * $limit;

            // Read filter params
            $search = trim((string) $this->request->get('search'));
            $filterOccupied = $this->request->get('occupied');
            $filterAvailable = $this->request->get('available');
            $filterMaintenance = $this->request->get('maintenance');

            $filters = [];
            // status precedence: if both occupied and available are checked, treat as no status filter
            // If exactly one status is selected, apply that status. If multiple or none, do not filter by status.
            $statusCount = (!empty($filterOccupied) ? 1 : 0) + (!empty($filterAvailable) ? 1 : 0) + (!empty($filterMaintenance) ? 1 : 0);
            if ($statusCount === 1) {
                if (!empty($filterOccupied)) $filters['status'] = 'occupied';
                if (!empty($filterAvailable)) $filters['status'] = 'available';
                if (!empty($filterMaintenance)) $filters['status'] = 'maintenance';
            }

            if ($search !== '') {
                $filters['search'] = $search;
            }

            // If filters exist, use filtered methods; otherwise use unfiltered paginated methods
            if (!empty($filters)) {
                $totalRoomsCount = $this->roomModel->getRoomsCountByHouseIdWithFilters($selectedHouse['id'], $filters);
                $rooms = $this->roomModel->getRoomsByHouseIdWithFiltersPaginated($selectedHouse['id'], $limit, $offset, $filters);
            } else {
                $totalRoomsCount = $this->roomModel->getRoomsCountByHouseId($selectedHouse['id']);
                $rooms = $this->roomModel->getRoomsByHouseIdPaginated($selectedHouse['id'], $limit, $offset);
            }

            // room stats and summary
            $roomStats = $this->roomModel->getRoomStatistics($selectedHouse['id']);

            // Lấy tổng số tiện ích và dịch vụ
            $totalAmenities = count($this->amenityModel->getAmenitiesByHouseId($selectedHouse['id']));
            $totalServices = count($this->serviceModel->getServicesByHouseId($selectedHouse['id']));

            // build pagination
            $pagination = $this->getPagination($page, $totalRoomsCount, $limit, $offset);
            // carry query params for links
            $queryParams = ['house_id' => $selectedHouse['id']];
            if (!empty($search)) $queryParams['search'] = $search;
            if (!empty($filterOccupied)) $queryParams['occupied'] = 1;
            if (!empty($filterAvailable)) $queryParams['available'] = 1;
            if (!empty($filterMaintenance)) $queryParams['maintenance'] = 1;
        }

        // Tính toán dữ liệu cho summary cards
        $totalTenants = 0;
        $totalDeposit = 0;
        $totalRooms = 0;
        $maintenanceIssues = 0;
        $occupiedRooms = 0;
        $availableRooms = 0;

        // Lấy số lượng khách thuê và tổng số phòng cho nhà trọ được chọn
        if ($selectedHouse) {
            $totalTenants = $this->tenantModel->countTenantsByHouseId($selectedHouse['id'], $this->user['id']);
            $totalRooms = $this->roomModel->getRoomsCountByHouseId($selectedHouse['id']);
        }

        // Tính số phòng theo trạng thái từ roomStats
        foreach ($roomStats as $stat) {
            if ($stat['room_status'] === 'occupied') {
                $occupiedRooms = (int) $stat['count'];
            } elseif ($stat['room_status'] === 'available') {
                $availableRooms = (int) $stat['count'];
            } elseif ($stat['room_status'] === 'maintenance') {
                $maintenanceIssues = (int) $stat['count'];
            }
        }

        foreach ($rooms as $room) {
            $totalDeposit += $room['deposit'] ?? 0;
        }

        // Render view
        ViewRender::render('landlord/index', [
            'houses' => $houses,
            'selectedHouse' => $selectedHouse,
            'rooms' => $rooms,
            'roomStats' => $roomStats,
            'totalTenants' => $totalTenants,
            'totalDeposit' => $totalDeposit,
            'totalRooms' => $totalRooms,
            'maintenanceIssues' => $maintenanceIssues,
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,
            'totalAmenities' => $totalAmenities,
            'totalServices' => $totalServices,
            'pagination' => $pagination ?? null,
            'queryParams' => $queryParams ?? [],
        ]);
    }

    /**
     * Tạo mới nhà trọ
     */
    public function create() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord', 'Phương thức không hợp lệ!');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra. Vui lòng thử lại sau!');
            return;
        }

        // Lấy dữ liệu từ request
        $houseData = [
            'owner_id' => $this->user['id'],
            'house_name' => $this->request->post('house_name'),
            'province' => $this->request->post('province'),
            'ward' => $this->request->post('ward'),
            'address' => $this->request->post('address'),
            'payment_date' => $this->request->post('payment_date'),
            'due_date' => $this->request->post('due_date'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Validate dữ liệu
        if (
            empty($houseData['house_name']) || empty($houseData['province']) ||
            empty($houseData['ward']) || empty($houseData['address']) ||
            empty($houseData['payment_date']) || empty($houseData['due_date'])
        ) {
            $this->request->redirectWithError('/landlord', 'Vui lòng điền đầy đủ thông tin bắt buộc!');
            return;
        }

        try {
            // Gọi model để tạo nhà trọ
            $result = $this->houseModel->createHouse($houseData);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Tạo nhà trọ thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi tạo nhà trọ!');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage() . '!');
        }
    }

    /**
     * Cập nhật nhà trọ
     */
    public function update() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord', 'Phương thức không hợp lệ!');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra. Vui lòng thử lại sau!');
            return;
        }

        // Lấy house_id từ request
        $houseId = $this->request->post('house_id');

        if (empty($houseId)) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy ID nhà trọ!');
            return;
        }

        // Kiểm tra nhà trọ có tồn tại và thuộc về landlord này không
        $existingHouse = $this->houseModel->getHouseById($houseId, $this->user['id']);
        if (!$existingHouse) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy nhà trọ hoặc bạn không có quyền chỉnh sửa!');
            return;
        }

        // Lấy dữ liệu từ request
        $houseData = [
            'house_name' => $this->request->post('house_name'),
            'province' => $this->request->post('province'),
            'ward' => $this->request->post('ward'),
            'address' => $this->request->post('address'),
            'payment_date' => $this->request->post('payment_date'),
            'due_date' => $this->request->post('due_date'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Validate dữ liệu
        if (
            empty($houseData['house_name']) || empty($houseData['province']) ||
            empty($houseData['ward']) || empty($houseData['address']) ||
            empty($houseData['payment_date']) || empty($houseData['due_date'])
        ) {
            $this->request->redirectWithError('/landlord', 'Vui lòng điền đầy đủ thông tin bắt buộc!');
            return;
        }

        try {
            // Gọi model để cập nhật nhà trọ
            $result = $this->houseModel->updateHouse($houseId, $houseData);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Cập nhật nhà trọ thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi cập nhật nhà trọ!');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage() . '!');
        }
    }

    /**
     * Lấy thông tin nhà trọ theo ID
     */
    public function getHouse($houseId) {
        // Lấy owner_id từ session
        $ownerId = Session::get('user_id');

        if (!$ownerId) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy thông tin người dùng!');
            return;
        }

        try {
            // Lấy thông tin nhà trọ
            $house = $this->houseModel->getHouseById($houseId, $ownerId);

            if ($house) {
                // Trả về JSON response
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'house' => $house,
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy nhà trọ',
                ]);
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Xóa nhà trọ (soft delete)
     */
    public function delete() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord', 'Phương thức không hợp lệ!');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra. Vui lòng thử lại sau!');
            return;
        }

        // Lấy house_id từ request
        $houseId = $this->request->post('house_id');

        if (empty($houseId)) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy ID nhà trọ!');
            return;
        }

        // Kiểm tra nhà trọ có tồn tại và thuộc về landlord này không
        $existingHouse = $this->houseModel->getHouseById($houseId, $this->user['id']);
        if (!$existingHouse) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy nhà trọ hoặc bạn không có quyền xóa!');
            return;
        }

        // Kiểm tra xem nhà trọ có phòng nào không
        $rooms = $this->roomModel->getRoomsByHouseId($houseId);

        if (!empty($rooms)) {
            $this->request->redirectWithError('/landlord', 'Không thể xóa nhà trọ này vì đang có ' . count($rooms) . ' phòng. Vui lòng xóa tất cả phòng trước khi xóa nhà trọ.');
            return;
        }

        try {
            // Gọi model để xóa nhà trọ (soft delete)
            $result = $this->houseModel->deleteHouse($houseId);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Xóa nhà trọ thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi xóa nhà trọ');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Added by Huy Nguyen on 2025-12-14 to get address house
    public function getAddressHouse() {
        $requests = $this->request->post();

        if (!isset($requests['house_id']) || empty($requests['house_id'])) {
            Response::json(['status' => 'error', 'msg' => 'Chưa có nhà trọ được chọn', 'token' => CSRF::getTokenRefresh()], 400);
            return;
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 401);
            return;
        }

        $house = $this->houseModel->getHouseById($requests['house_id'], $this->user['id']);
        
        if ($house) {
            Response::json(['status' => 'success', 'house' => $house, 'token' => CSRF::getTokenRefresh()], 200);
        } else {
            Response::json(['status' => 'error', 'msg' => 'Không tìm thấy nhà trọ', 'token' => CSRF::getTokenRefresh()], 404);
        }
    }
}
