<?php
/*
Author: Nguyen Xuan Duong
Date: 2025-09-05
Purpose: Build Amenity Model
 */
namespace App\Models;

use Core\QueryBuilder;

class Amenity {
    private $queryBuilder;

    public function __construct() {
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Lấy danh sách tài sản theo house_id
     */
    public function getAmenitiesByHouseId($houseId) {
        return $this->queryBuilder
            ->table('amenities')
            ->where('house_id', $houseId)
            ->where('deleted', 0)
            ->orderBy('amenity_name', 'ASC')
            ->get();
    }

    /**
     * Lấy tài sản theo ID
     */
    public function getAmenityById($amenityId, $ownerId = null) {
        $query = $this->queryBuilder
            ->table('amenities')
            ->where('amenities.id', $amenityId)
            ->where('amenities.deleted', 0);

        if ($ownerId) {
            $query->join('houses', 'amenities.house_id', '=', 'houses.id')
                ->where('houses.owner_id', $ownerId);
        }

        return $query->first();
    }

    /**
     * Tạo tài sản mới
     */
    public function createAmenity($amenityData) {
        return $this->queryBuilder
            ->table('amenities')
            ->insert($amenityData);
    }

    /**
     * Cập nhật tài sản
     */
    public function updateAmenity($amenityId, $amenityData) {
        return $this->queryBuilder
            ->table('amenities')
            ->where('amenities.id', $amenityId)
            ->where('amenities.deleted', 0)
            ->update($amenityData);
    }

    /**
     * Đếm số phòng sử dụng tài sản
     */
    public function getRoomCountByAmenityId($amenityId) {
        $result = $this->queryBuilder
            ->table('room_amenities')
            ->select('COUNT(*) as count')
            ->where('amenity_id', $amenityId)
            ->first();

        return $result ? $result['count'] : 0;
    }

    /**
     * Tính tổng số lượng tài sản đang được sử dụng bởi các phòng có khách thuê (dựa trên room_status)
     */
    public function getUsedQuantityByAmenityId($amenityId, $houseId = null) {
        $query = $this->queryBuilder
            ->table('room_amenities')
            ->select('SUM(room_amenities.quantity) as total_used')
            ->join('rooms', 'room_amenities.room_id', '=', 'rooms.id')
            ->where('room_amenities.amenity_id', $amenityId)
            ->where('rooms.room_status', 'occupied')
            ->where('rooms.deleted', 0);

        if ($houseId) {
            $query->where('rooms.house_id', $houseId);
        }

        $result = $query->first();
        return $result ? (int) $result['total_used'] : 0;
    }

    /**
     * Lấy danh sách phòng sử dụng tài sản
     */
    public function getRoomsByAmenityId($amenityId, $ownerId) {
        return $this->queryBuilder
            ->table('room_amenities')
            ->select(['room_amenities.room_id', 'rooms.room_name'])
            ->join('rooms', 'room_amenities.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('room_amenities.amenity_id', $amenityId)
            ->where('houses.owner_id', $ownerId)
            ->get();
    }

    /**
     * Lấy danh sách phòng đang áp dụng tài sản (tất cả phòng)
     */
    public function getUsedRoomsByAmenityId($amenityId, $houseId = null) {
        $query = $this->queryBuilder
            ->table('room_amenities')
            ->select(['rooms.room_name', 'room_amenities.quantity', 'rooms.room_status'])
            ->join('rooms', 'room_amenities.room_id', '=', 'rooms.id')
            ->where('room_amenities.amenity_id', $amenityId)
            ->where('rooms.deleted', 0);

        if ($houseId) {
            $query->where('rooms.house_id', $houseId);
        }

        return $query->get();
    }

    /**
     * Gán tài sản cho phòng
     */
    public function assignAmenityToRoom($roomId, $amenityId, $quantity = 1) {
        // Kiểm tra xem đã tồn tại chưa
        $existing = $this->queryBuilder
            ->table('room_amenities')
            ->where('room_id', $roomId)
            ->where('amenity_id', $amenityId)
            ->first();

        if ($existing) {
            // Cập nhật quantity
            return $this->queryBuilder
                ->table('room_amenities')
                ->where('room_id', $roomId)
                ->where('amenity_id', $amenityId)
                ->update([
                    'quantity' => $quantity,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        } else {
            // Tạo mới
            return $this->queryBuilder
                ->table('room_amenities')
                ->insert([
                    'room_id' => $roomId,
                    'amenity_id' => $amenityId,
                    'quantity' => $quantity,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        }
    }

    /**
     * Xóa tất cả phòng khỏi tài sản
     */
    public function removeAllRoomsFromAmenity($amenityId) {
        return $this->queryBuilder
            ->table('room_amenities')
            ->where('amenity_id', $amenityId)
            ->delete();
    }

    /**
     * Kiểm tra có thể xóa tài sản không
     */
    public function canDeleteAmenity($amenityId, $ownerId) {
        // Kiểm tra tài sản có tồn tại và thuộc về owner không
        $amenity = $this->getAmenityById($amenityId, $ownerId);
        if (!$amenity) {
            return ['can_delete' => false, 'reason' => 'Không tìm thấy tài sản hoặc bạn không có quyền truy cập'];
        }

        // Kiểm tra có phòng nào đang sử dụng tài sản này không
        $roomCount = $this->getRoomCountByAmenityId($amenityId);

        if ($roomCount > 0) {
            // Kiểm tra xem các phòng này có khách thuê không (dựa trên room_status)
            $result = $this->queryBuilder
                ->table('room_amenities')
                ->select('COUNT(DISTINCT room_amenities.room_id) as count')
                ->join('rooms', 'room_amenities.room_id', '=', 'rooms.id')
                ->join('houses', 'rooms.house_id', '=', 'houses.id')
                ->where('room_amenities.amenity_id', $amenityId)
                ->where('houses.owner_id', $ownerId)
                ->where('rooms.room_status', 'occupied')
                ->first();
            $occupiedRoomCount = $result ? $result['count'] : 0;

            if ($occupiedRoomCount > 0) {
                return ['can_delete' => false, 'reason' => 'Tài sản đang được sử dụng bởi ' . $occupiedRoomCount . ' phòng có khách thuê'];
            }

            // Có phòng sử dụng nhưng không có khách thuê - có thể xóa
            return ['can_delete' => true, 'reason' => 'Tài sản đang được sử dụng bởi ' . $roomCount . ' phòng trống. Xóa sẽ gỡ bỏ tài sản khỏi tất cả phòng.', 'has_rooms' => true];
        }

        // Không có phòng nào sử dụng - có thể xóa
        return ['can_delete' => true, 'reason' => 'Tài sản chưa được sử dụng bởi phòng nào'];
    }

    /**
     * Xóa tài sản
     */
    public function deleteAmenity($amenityId, $ownerId) {
        // Kiểm tra có thể xóa không
        $canDelete = $this->canDeleteAmenity($amenityId, $ownerId);

        if (!$canDelete['can_delete']) {
            return $canDelete;
        }

        try {
            // Bắt đầu transaction
            $this->queryBuilder->beginTransaction();

            // Nếu có phòng sử dụng, xóa khỏi room_amenities
            if (isset($canDelete['has_rooms']) && $canDelete['has_rooms']) {
                $this->removeAllRoomsFromAmenity($amenityId);
            }

            // Xóa tài sản (soft delete)
            $result = $this->queryBuilder
                ->table('amenities')
                ->where('amenities.id', $amenityId)
                ->update([
                    'deleted' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            if ($result) {
                $this->queryBuilder->commit();
                return ['success' => true, 'message' => 'Xóa tài sản thành công!'];
            } else {
                $this->queryBuilder->rollback();
                return ['success' => false, 'message' => 'Có lỗi xảy ra khi xóa tài sản'];
            }
        } catch (\Exception $e) {
            $this->queryBuilder->rollback();
            return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
        }
    }

    /**
     * Execute raw SQL query
     */
    public function query($sql, $params = []) {
        return $this->queryBuilder->query($sql, $params);
    }

    /**
     * Transaction methods
     */
    public function beginTransaction() {
        return $this->queryBuilder->beginTransaction();
    }

    public function commit() {
        return $this->queryBuilder->commit();
    }

    public function rollback() {
        return $this->queryBuilder->rollback();
    }

    // Added by Huy Nguyen get amenities by room id
    public function getAmenitiesByRoomId($roomId) {
        return $this->queryBuilder
            ->table('room_amenities')
            ->select('amenities.*')
            ->join('amenities', 'room_amenities.amenity_id', '=', 'amenities.id')
            ->join('rooms', 'room_amenities.room_id', '=', 'rooms.id')
            ->where('rooms.id', $roomId)
            ->where('amenities.deleted', 0)
            ->get();
    }
}
