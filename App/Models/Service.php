<?php
/*
Author: Nguyen Xuan Duong
Date: 2025-09-05
Purpose: Build Service Model
 */
namespace App\Models;

use App\Models\Model;
use Core\QueryBuilder;

class Service extends Model {
    protected $table = 'services';
    private $queryBuilder;

    public function __construct() {
        parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Lấy tất cả dịch vụ của một nhà
     */
    public function getServicesByHouseId($houseId) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('house_id', $houseId)
            ->orderBy('service_name')
            ->get();
    }

    /**
     * Lấy dịch vụ theo ID
     */
    public function getServiceById($serviceId) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $serviceId)
            ->first();
    }

    /**
     * Tạo dịch vụ mới
     */
    public function createService($data) {
        return $this->queryBuilder
            ->table($this->table)
            ->insert($data);
    }

    /**
     * Cập nhật dịch vụ
     */
    public function updateService($serviceId, $data) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $serviceId)
            ->update($data);
    }

    /**
     * Lấy dịch vụ của một phòng cụ thể
     */
    public function getServicesByRoomId($roomId) {
        return $this->queryBuilder
            ->table('room_services')
            ->select('services.*')
            ->join('services', 'room_services.service_id', '=', 'services.id')
            ->where('room_services.room_id', $roomId)
            ->get();
    }

    /**
     * Đếm số phòng áp dụng cho một dịch vụ
     */
    public function getRoomCountByServiceId($serviceId) {
        $result = $this->queryBuilder
            ->table('room_services')
            ->select('COUNT(*) as count')
            ->where('service_id', $serviceId)
            ->first();

        return $result ? $result['count'] : 0;
    }

    /**
     * Lấy danh sách phòng của một dịch vụ
     */
    public function getRoomsByServiceId($serviceId, $ownerId) {
        $result = $this->queryBuilder
            ->table('room_services')
            ->select('room_services.room_id')
            ->join('rooms', 'room_services.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('room_services.service_id', $serviceId)
            ->where('houses.owner_id', $ownerId)
            ->get();

        if ($result) {
            return array_column($result, 'room_id');
        }

        return false;
    }

    /**
     * Gán dịch vụ cho phòng
     */
    public function assignServiceToRoom($roomId, $serviceId) {
        return $this->queryBuilder
            ->table('room_services')
            ->insert([
                'room_id' => $roomId,
                'service_id' => $serviceId,
            ]);
    }

    /**
     * Xóa tất cả phòng khỏi dịch vụ
     */
    public function removeAllRoomsFromService($serviceId) {
        return $this->queryBuilder
            ->table('room_services')
            ->where('service_id', $serviceId)
            ->delete();
    }

    /**
     * Hủy gán dịch vụ cho phòng
     */
    public function unassignServiceFromRoom($roomId, $serviceId) {
        return $this->queryBuilder
            ->table('room_services')
            ->where('room_id', $roomId)
            ->where('service_id', $serviceId)
            ->delete();
    }

    /**
     * Lấy lịch sử sử dụng dịch vụ của phòng
     */
    public function getServiceUsageByRoom($roomId, $monthYear = null) {
        $query = $this->queryBuilder
            ->table('service_usages')
            ->select('service_usages.*', 'services.service_name', 'services.unit')
            ->join('services', 'service_usages.service_id', '=', 'services.id')
            ->where('service_usages.room_id', $roomId);

        if ($monthYear) {
            $query->where('service_usages.month_year', $monthYear);
        }

        return $query->orderBy('service_usages.month_year', 'DESC')->get();
    }

    /**
     * Thêm lịch sử sử dụng dịch vụ
     */
    public function addServiceUsage($data) {
        return $this->queryBuilder
            ->table('service_usages')
            ->insert($data);
    }

    /**
     * Bắt đầu transaction
     */
    public function beginTransaction() {
        return $this->queryBuilder->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit() {
        return $this->queryBuilder->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback() {
        return $this->queryBuilder->rollback();
    }

    /**
     * Kiểm tra dịch vụ có thể xóa được không
     */
    public function canDeleteService($serviceId, $ownerId) {
        try {
            // Kiểm tra dịch vụ có tồn tại và thuộc về owner không
            $service = $this->queryBuilder
                ->table($this->table)
                ->join('houses', 'services.house_id', '=', 'houses.id')
                ->where('services.id', $serviceId)
                ->where('houses.owner_id', $ownerId)
                ->first();

            if (!$service) {
                return ['can_delete' => false, 'reason' => 'Dịch vụ không tồn tại hoặc bạn không có quyền truy cập'];
            }

            // Kiểm tra có phòng nào đang sử dụng dịch vụ này không
            $roomCount = $this->queryBuilder
                ->table('room_services')
                ->where('service_id', $serviceId)
                ->count();

            if ($roomCount > 0) {
                // Kiểm tra xem các phòng đang sử dụng dịch vụ có khách thuê không
                $result = $this->queryBuilder
                    ->table('room_services rs')
                    ->select('COUNT(DISTINCT rs.room_id) as count')
                    ->join('rooms r', 'rs.room_id', '=', 'r.id')
                    ->where('rs.service_id', $serviceId)
                    ->where('r.room_status', 'occupied')
                    ->first();
                $occupiedRoomCount = $result ? $result['count'] : 0;

                if ($occupiedRoomCount > 0) {
                    return ['can_delete' => false, 'reason' => 'Dịch vụ đang được sử dụng bởi ' . $occupiedRoomCount . ' phòng có khách thuê'];
                }

                // Có phòng sử dụng nhưng không có khách thuê - có thể xóa
                return ['can_delete' => true, 'reason' => 'Dịch vụ đang được sử dụng bởi ' . $roomCount . ' phòng trống. Xóa sẽ gỡ bỏ dịch vụ khỏi tất cả phòng.', 'has_rooms' => true];
            }

            // Kiểm tra có dữ liệu sử dụng không
            $usageCount = $this->queryBuilder
                ->table('service_usages')
                ->where('service_id', $serviceId)
                ->count();

            // Kiểm tra có hóa đơn nào sử dụng dịch vụ này không
            // Chỉ kiểm tra nếu dịch vụ có dữ liệu sử dụng
            $invoiceCount = 0;
            if ($usageCount > 0) {
                // Kiểm tra hóa đơn với JOIN
                $result = $this->queryBuilder
                    ->table('invoices i')
                    ->select('COUNT(DISTINCT i.id) as count')
                    ->join('service_usages su', 'i.room_id', '=', 'su.room_id')
                    ->where('su.service_id', $serviceId)
                    ->where('i.deleted', 0)
                    ->first();
                $invoiceCount = $result ? $result['count'] : 0;
            }

            if ($invoiceCount > 0) {
                return ['can_delete' => false, 'reason' => 'Không thể xóa dịch vụ đã có hóa đơn'];
            }

            if ($usageCount > 0) {
                return ['can_delete' => true, 'reason' => 'Dịch vụ có dữ liệu sử dụng. Xóa sẽ mất tất cả dữ liệu sử dụng.', 'has_usage' => true];
            }

            return ['can_delete' => true, 'reason' => 'Có thể xóa dịch vụ', 'has_usage' => false];

        } catch (\Exception $e) {
            // Log lỗi để debug
            error_log("Service canDeleteService error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return ['can_delete' => false, 'reason' => 'Có lỗi xảy ra khi kiểm tra: ' . $e->getMessage()];
        }
    }

    /**
     * Xóa dịch vụ và dữ liệu liên quan
     */
    public function deleteService($serviceId, $ownerId) {
        try {
            // Kiểm tra có thể xóa không
            $checkResult = $this->canDeleteService($serviceId, $ownerId);
            if (!$checkResult['can_delete']) {
                return ['success' => false, 'message' => $checkResult['reason']];
            }

            // Bắt đầu transaction
            $this->beginTransaction();

            // Xóa dữ liệu sử dụng nếu có
            if (isset($checkResult['has_usage']) && $checkResult['has_usage']) {
                $this->queryBuilder
                    ->table('service_usages')
                    ->where('service_id', $serviceId)
                    ->delete();
            }

            // Xóa liên kết phòng-dịch vụ nếu có phòng trống sử dụng
            if (isset($checkResult['has_rooms']) && $checkResult['has_rooms']) {
                $this->queryBuilder
                    ->table('room_services')
                    ->where('service_id', $serviceId)
                    ->delete();
            }

            // Lấy danh sách house_id của owner trước
            $houseIds = $this->queryBuilder
                ->table('houses')
                ->select('id')
                ->where('owner_id', $ownerId)
                ->get();

            $houseIdArray = array_column($houseIds, 'id');

            // Xóa dịch vụ
            $result = $this->queryBuilder
                ->table($this->table)
                ->where('id', $serviceId)
                ->whereIn('house_id', $houseIdArray)
                ->delete();

            if ($result) {
                $this->commit();
                return ['success' => true, 'message' => 'Xóa dịch vụ thành công'];
            } else {
                $this->rollback();
                return ['success' => false, 'message' => 'Không thể xóa dịch vụ'];
            }

        } catch (\PDOException $e) {
            $this->rollback();
            return ['success' => false, 'message' => 'Có lỗi xảy ra khi xóa dịch vụ: ' . $e->getMessage()];
        }
    }
}
