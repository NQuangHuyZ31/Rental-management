<?php

namespace App\Models;

use App\Models\Model;
use Core\QueryBuilder;

class Room extends Model {
    protected $table = 'rooms';
    private $queryBuilder;

    public function __construct() {
        parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }

    public function getRoomsByHouseId($houseId) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('house_id', $houseId)
            ->where('deleted', 0)
            ->orderBy('room_name')
            ->get();
    }

    public function getRoomById($roomId, $ownerId = null) {
        $query = $this->queryBuilder
            ->table($this->table)
            ->where('rooms.id', $roomId);

        // If ownerId is provided, join with houses table to check ownership
        if ($ownerId) {
            $query->join('houses', 'rooms.house_id', '=', 'houses.id')
                ->where('houses.owner_id', $ownerId)
                ->select('rooms.*');
        }

        return $query->first();
    }

    public function getRoomsByStatus($houseId, $status) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('house_id', $houseId)
            ->where('room_status', $status)
            ->where('deleted', 0)
            ->orderBy('room_name')
            ->get();
    }

    public function getRoomStatistics($houseId) {
        return $this->queryBuilder
            ->table($this->table)
            ->select(['room_status', 'COUNT(*) as count', 'SUM(room_price) as total_price', 'SUM(deposit) as total_deposit'])
            ->where('house_id', $houseId)
            ->where('deleted', 0)
            ->groupBy('room_status')
            ->get();
    }

    /**
     * Create a new room
     */
    public function createRoom($roomData) {
        return $this->queryBuilder
            ->table($this->table)
            ->insert($roomData);
    }

    /**
     * Update room by ID
     */
    public function updateRoom($roomId, $roomData) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $roomId)
            ->update($roomData);
    }

    /**
     * Delete room by ID (soft delete)
     */
    public function deleteRoom($roomId) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $roomId)
            ->update([
                'deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Check if room exists and belongs to owner
     */
    public function roomExistsForOwner($roomId, $ownerId) {
        $result = $this->queryBuilder
            ->table($this->table)
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('rooms.id', $roomId)
            ->where('houses.owner_id', $ownerId)
            ->select('rooms.id')
            ->first();

        return $result !== false;
    }

    /**
     * Get room with house information
     */
    public function getRoomWithHouse($roomId, $ownerId = null) {
        $query = $this->queryBuilder
            ->table($this->table)
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->select('rooms.*', 'houses.house_name', 'houses.owner_id');

        if ($ownerId) {
            $query->where('houses.owner_id', $ownerId);
        }

        return $query->where('rooms.id', $roomId)->first();
    }

    /**
     * Get rooms by house ID with house information
     */
    public function getRoomsByHouseIdWithHouse($houseId, $ownerId = null) {
        $query = $this->queryBuilder
            ->table($this->table)
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->select('rooms.*', 'houses.house_name', 'houses.owner_id')
            ->where('rooms.house_id', $houseId)
            ->orderBy('rooms.room_name');

        if ($ownerId) {
            $query->where('houses.owner_id', $ownerId);
        }

        return $query->get();
    }

    /**
     * Get room statistics by house ID
     */
    public function getRoomStatisticsByHouse($houseId, $ownerId = null) {
        $query = $this->queryBuilder
            ->table($this->table)
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->select([
                'rooms.room_status',
                'COUNT(*) as count',
                'SUM(rooms.room_price) as total_price',
                'SUM(rooms.deposit) as total_deposit',
            ])
            ->where('rooms.house_id', $houseId)
            ->groupBy('rooms.room_status');

        if ($ownerId) {
            $query->where('houses.owner_id', $ownerId);
        }

        return $query->get();
    }

    /**
     * Check if room can be deleted (not occupied)
     */
    public function canDeleteRoom($roomId) {
        $room = $this->queryBuilder
            ->table($this->table)
            ->where('id', $roomId)
            ->select('room_status')
            ->first();

        if (!$room) {
            return ['can_delete' => false, 'reason' => 'Không tìm thấy phòng'];
        }

        if ($room['room_status'] === 'occupied') {
            return ['can_delete' => false, 'reason' => 'Không thể xóa phòng đang được thuê'];
        }

        return ['can_delete' => true, 'reason' => ''];
    }

    /**
     * Get all rooms by user ID (landlord)
     */
    public function getAllRoomsByUserId($userId) {
        return $this->queryBuilder
            ->table($this->table)
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->select('rooms.*', 'houses.house_name', 'houses.owner_id')
            ->where('houses.owner_id', $userId)
            ->where('rooms.deleted', 0)
            ->orderBy('houses.house_name')
            ->orderBy('rooms.room_name')
            ->get();
    }

    /**
     * Get available rooms by house ID
     */
    // Modify by Huy Nguyen on 2025-10-21 to support get by status
    public function getAvailableRoomsByHouseId($houseId, $status = 'available', $ownerId = false) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('house_id', $houseId)
            ->where('room_status', $status)
            ->where('deleted', 0)
            ->orderBy('room_name')
            ->get();
    }

    /**
     * Update room status
     */
    public function updateRoomStatus($roomId, $status) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $roomId)
            ->update([
                'room_status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }
}
