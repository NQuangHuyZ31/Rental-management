<?php

/*
	Author: Nguyen Xuan Duong
	Date: 2025-08-29
	Purpose: Build House Controller
*/

namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use App\Models\Landlord\Room;
use Core\Request;
use Core\Session;
use Core\ViewRender;
use Core\CSRF;

class HouseController extends LandlordController
{
    private $roomModel;
    private $request;

    public function __construct()
    {
        parent::__construct();
        $this->roomModel = new Room();
        $this->request = new Request();
    }

    /**
     * Hiển thị trang chủ landlord
     */
    public function index()
    {
        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Sử dụng logic chung từ BaseLandlordController
        [$selectedHouse, $houses, $selectedHouseId] = $this->getSelectedHouse($ownerId, $this->request->get('house_id'));

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

        // Render view
        ViewRender::render('landlord/index', [
            'houses' => $houses,
            'selectedHouse' => $selectedHouse,
            'rooms' => $rooms,
            'roomStats' => $roomStats,
            'totalDebt' => $totalDebt,
            'totalDeposit' => $totalDeposit,
            'totalReservationDeposit' => $totalReservationDeposit,
            'maintenanceIssues' => $maintenanceIssues
        ]);
    }

    /**
     * Tạo mới nhà trọ
     */
    public function create()
    {
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

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy dữ liệu từ request
        $houseData = [
            'owner_id' => $ownerId,
            'house_name' => $this->request->post('house_name'),
            'province' => $this->request->post('province'),
            'ward' => $this->request->post('ward'),
            'address' => $this->request->post('address'),
            'payment_date' => $this->request->post('payment_date'),
            'due_date' => $this->request->post('due_date'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Validate dữ liệu
        if (
            empty($houseData['house_name']) || empty($houseData['province']) ||
            empty($houseData['ward']) || empty($houseData['address']) ||
            empty($houseData['payment_date']) || empty($houseData['due_date'])
        ) {
            $this->request->redirectWithError('/landlord', 'Vui lòng điền đầy đủ thông tin bắt buộc');
            return;
        }

        try {
            // Gọi model để tạo nhà trọ
            $result = $this->houseModel->createHouse($houseData);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Tạo nhà trọ thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi tạo nhà trọ');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật nhà trọ
     */
    public function update()
    {
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

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy house_id từ request
        $houseId = $this->request->post('house_id');

        if (empty($houseId)) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy ID nhà trọ');
            return;
        }

        // Kiểm tra nhà trọ có tồn tại và thuộc về landlord này không
        $existingHouse = $this->houseModel->getHouseById($houseId, $ownerId);
        if (!$existingHouse) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy nhà trọ hoặc bạn không có quyền chỉnh sửa');
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
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Validate dữ liệu
        if (
            empty($houseData['house_name']) || empty($houseData['province']) ||
            empty($houseData['ward']) || empty($houseData['address']) ||
            empty($houseData['payment_date']) || empty($houseData['due_date'])
        ) {
            $this->request->redirectWithError('/landlord', 'Vui lòng điền đầy đủ thông tin bắt buộc');
            return;
        }

        try {
            // Gọi model để cập nhật nhà trọ
            $result = $this->houseModel->updateHouse($houseId, $houseData);

            if ($result) {
                $this->request->redirectWithSuccess('/landlord', 'Cập nhật nhà trọ thành công!');
            } else {
                $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra khi cập nhật nhà trọ');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/landlord', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Lấy thông tin nhà trọ theo ID
     */
    public function getHouse($houseId)
    {
        // Lấy owner_id từ session
        $ownerId = Session::get('user_id');

        if (!$ownerId) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy thông tin người dùng');
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
                    'house' => $house
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy nhà trọ'
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
     * Xóa nhà trọ (soft delete)
     */
    public function delete()
    {
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

        // Lấy thông tin user đã đăng nhập
        $user = Session::get('user');
        $ownerId = $user['id'];

        // Lấy house_id từ request
        $houseId = $this->request->post('house_id');

        if (empty($houseId)) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy ID nhà trọ');
            return;
        }

        // Kiểm tra nhà trọ có tồn tại và thuộc về landlord này không
        $existingHouse = $this->houseModel->getHouseById($houseId, $ownerId);
        if (!$existingHouse) {
            $this->request->redirectWithError('/landlord', 'Không tìm thấy nhà trọ hoặc bạn không có quyền xóa');
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
}
