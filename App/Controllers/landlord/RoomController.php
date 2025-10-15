<?php

/*
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Build Room Controller
 */

namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use Core\CSRF;
use Core\Session;
use Core\ViewRender;
use Helpers\Validate;

class RoomController extends LandlordController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Hiển thị trang chủ landlord với danh sách phòng
     */
    public function index() {

        // Sử dụng logic chung từ BaseLandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($this->user['id'], $this->request->get('house_id'));

        $rooms = [];
        $roomStats = [];

        // Lấy danh sách phòng của nhà trọ được chọn
        if ($selectedHouse) {
            $rooms = $this->roomModel->getRoomsByHouseId($selectedHouse['id']);
            $roomStats = $this->roomModel->getRoomStatistics($selectedHouse['id']);
        }

        // Tính toán dữ liệu cho summary cards
        $totalDebt = 0;
        $totalDeposit = 0;
        $totalReservationDeposit = 0;
        $maintenanceIssues = 0;

        foreach ($rooms as $room) {
            $totalDeposit += $room['deposit'] ?? 0;
            if ($room['room_status'] === 'occupied') {
                $totalDebt += $room['room_price'] ?? 0;
            }
            if ($room['room_status'] === 'maintenance') {
                $maintenanceIssues++;
            }
        }

        // Get validation errors and old input from session
        $validationErrors = Session::get('validation_errors', []);
        $oldInput = Session::get('old_input', []);

        // Clear validation data from session after retrieving
        Session::delete('validation_errors');
        Session::delete('old_input');

        // Render view
        ViewRender::render('landlord/index', [
            'houses' => $houses,
            'selectedHouse' => $selectedHouse,
            'rooms' => $rooms,
            'roomStats' => $roomStats,
            'totalDebt' => $totalDebt,
            'totalDeposit' => $totalDeposit,
            'totalReservationDeposit' => $totalReservationDeposit,
            'maintenanceIssues' => $maintenanceIssues,
            'validationErrors' => $validationErrors,
            'oldInput' => $oldInput,
        ]);
    }

    /**
     * Tạo mới phòng
     */
    public function create() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }


        // Lấy dữ liệu từ request
        $roomData = [
            'house_id' => $this->request->post('house_id'),
            'room_name' => $this->request->post('room_name'),
            'floor' => $this->request->post('floor'),
            'area' => $this->request->post('area'),
            'room_price' => $this->request->post('room_price'),
            'deposit' => $this->request->post('deposit'),
            'max_people' => $this->request->post('max_people'),
            'room_status' => $this->request->post('room_status'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Validate dữ liệu using Helper Validate
        $validationErrors = Validate::validateRoomData($roomData);
        if (!empty($validationErrors)) {
            // Store validation errors in session to display under fields
            Session::set('validation_errors', $validationErrors);
            Session::set('old_input', $roomData);
            $this->request->redirectWithError('/landlord', 'Vui lòng kiểm tra lại thông tin đã nhập');
            return;
        }

        // Kiểm tra nhà trọ có tồn tại và thuộc về landlord này không
        $existingHouse = $this->houseModel->getHouseById($roomData['house_id'], $this->user['id']);
        if (!$existingHouse) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy nhà trọ hoặc bạn không có quyền thêm phòng');
            return;
        }

        try {
            // Gọi model để tạo phòng
            $result = $this->roomModel->createRoom($roomData);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Tạo phòng thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi tạo phòng');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật phòng
     */
    public function update() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }


        // Lấy room_id từ request
        $roomId = $this->request->post('room_id');

        if (empty($roomId)) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy ID phòng');
            return;
        }

        // Kiểm tra phòng có tồn tại và thuộc về landlord này không
        $existingRoom = $this->roomModel->getRoomById($roomId, $this->user['id']);
        if (!$existingRoom) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy phòng hoặc bạn không có quyền chỉnh sửa');
            return;
        }

        // Lấy dữ liệu từ request
        $roomData = [
            'room_name' => $this->request->post('room_name'),
            'floor' => $this->request->post('floor'),
            'area' => $this->request->post('area'),
            'room_price' => $this->request->post('room_price'),
            'deposit' => $this->request->post('deposit'),
            'max_people' => $this->request->post('max_people'),
            'room_status' => $this->request->post('room_status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Validate dữ liệu using Helper Validate
        $validationErrors = Validate::validateRoomDataForUpdate($roomData);
        if (!empty($validationErrors)) {
            // Store validation errors in session to display under fields
            Session::set('validation_errors', $validationErrors);
            Session::set('old_input', $roomData);
            $this->request->redirectWithError('/landlord', 'Vui lòng kiểm tra lại thông tin đã nhập');
            return;
        }

        try {
            // Gọi model để cập nhật phòng
            $result = $this->roomModel->updateRoom($roomId, $roomData);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Cập nhật phòng thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi cập nhật phòng');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Lấy thông tin phòng theo ID
     */
    public function getRoom($roomId) {
        // Lấy owner_id từ session
        $this->user['id'] = Session::get('user')['id'];

        if (!$this->user['id']) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy thông tin người dùng');
            return;
        }

        try {
            // Lấy thông tin phòng
            $room = $this->roomModel->getRoomById($roomId, $this->user['id']);

            if ($room) {
                // Trả về JSON response
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'room' => $room,
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy phòng',
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
     * Xóa phòng (soft delete)
     */
    public function delete() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/landlord', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/landlord', 'CSRF token không hợp lệ hoặc đã hết hạn');
            return;
        }


        // Lấy room_id từ request
        $roomId = $this->request->post('room_id');

        if (empty($roomId)) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy ID phòng');
            return;
        }

        // Kiểm tra phòng có tồn tại và thuộc về landlord này không
        $existingRoom = $this->roomModel->getRoomById($roomId, $this->user['id']);
        if (!$existingRoom) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy phòng hoặc bạn không có quyền xóa');
            return;
        }

        // Kiểm tra xem phòng có đang được thuê không
        if ($existingRoom['room_status'] === 'occupied') {
            $this->request->redirectWithError('/landlord', 'Không thể xóa phòng đang được thuê. Vui lòng chuyển trạng thái phòng trước khi xóa.');
            return;
        }

        try {
            // Gọi model để xóa phòng (soft delete)
            $result = $this->roomModel->deleteRoom($roomId);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Xóa phòng thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi xóa phòng');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
