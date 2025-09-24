<?php
/*
Author: Nguyen Xuan Duong
Date: 2025-09-07
Purpose: Build Tenant Model
 */
namespace App\Models;
use App\Models\Model;
use Core\QueryBuilder;

class Tenant extends Model {
    protected $table = 'room_tenants';
    private $queryBuilder;

    public function __construct() {
        parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Lấy danh sách khách thuê theo house_id, nhóm theo phòng (chỉ khách chưa rời)
     */
    public function getTenantsByHouseId($houseId, $ownerId) {
        return $this->queryBuilder
            ->table($this->table)
            ->select([
                'users.id',
                'users.username',
                'users.phone',
                'users.gender',
                'users.birthday',
                'users.job',
                'users.province',
                'users.ward',
                'users.address',
                'users.citizen_id',
                'rooms.id as room_id',
                'rooms.room_name',
                'room_tenants.join_date',
                'room_tenants.expected_leave_date',
                'room_tenants.is_primary',
            ])
            ->join('users', 'room_tenants.user_id', '=', 'users.id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.id', $houseId)
            ->where('houses.owner_id', $ownerId)
            ->where('users.deleted', 0)
            ->where('rooms.deleted', 0)
            ->whereNull('room_tenants.left_date')
            ->orderBy('rooms.room_name', 'ASC')
            ->orderBy('room_tenants.is_primary', 'DESC')
            ->orderBy('users.username', 'ASC')
            ->get();
    }

    /**
     * Lấy thông tin chi tiết khách thuê theo ID
     */
    public function getTenantById($tenantId, $ownerId) {
        return $this->queryBuilder
            ->table($this->table)
            ->select([
                'users.id',
                'users.username',
                'users.email',
                'users.phone',
                'users.gender',
                'users.birthday',
                'users.job',
                'users.province',
                'users.ward',
                'users.address',
                'users.citizen_id',
                'users.account_status',
                'users.last_login',
                'rooms.room_name',
                'houses.house_name',
                'room_tenants.join_date',
                'room_tenants.expected_leave_date',
                'room_tenants.left_date',
                'room_tenants.is_primary',
                'room_tenants.note',
            ])
            ->join('users', 'room_tenants.user_id', '=', 'users.id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('users.id', $tenantId)
            ->where('houses.owner_id', $ownerId)
            ->where('users.deleted', 0)
            ->where('rooms.deleted', 0)
            ->first();
    }

    /**
     * Lấy danh sách khách thuê đang ở (chưa rời)
     */
    public function getActiveTenantsByHouseId($houseId, $ownerId) {
        return $this->queryBuilder
            ->table($this->table)
            ->select([
                'users.id',
                'users.username',
                'users.phone',
                'users.gender',
                'users.birthday',
                'users.job',
                'users.province',
                'users.ward',
                'users.address',
                'users.citizen_id',
                'rooms.room_name',
                'room_tenants.join_date',
                'room_tenants.expected_leave_date',
                'room_tenants.is_primary',
            ])
            ->join('users', 'room_tenants.user_id', '=', 'users.id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.id', $houseId)
            ->where('houses.owner_id', $ownerId)
            ->where('users.deleted', 0)
            ->where('rooms.deleted', 0)
            ->whereNull('room_tenants.left_date')
            ->orderBy('users.username', 'ASC')
            ->get();
    }

    /**
     * Lấy danh sách khách thuê đã rời
     */
    public function getLeftTenantsByHouseId($houseId, $ownerId) {
        return $this->queryBuilder
            ->table($this->table)
            ->select([
                'users.id',
                'users.username',
                'users.phone',
                'users.gender',
                'users.birthday',
                'users.job',
                'users.province',
                'users.ward',
                'users.address',
                'users.citizen_id',
                'rooms.room_name',
                'room_tenants.join_date',
                'room_tenants.expected_leave_date',
                'room_tenants.left_date',
                'room_tenants.is_primary',
            ])
            ->join('users', 'room_tenants.user_id', '=', 'users.id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.id', $houseId)
            ->where('houses.owner_id', $ownerId)
            ->where('users.deleted', 0)
            ->where('rooms.deleted', 0)
            ->whereNotNull('room_tenants.left_date')
            ->orderBy('room_tenants.left_date', 'DESC')
            ->get();
    }

    /**
     * Đếm số khách thuê theo house_id
     */
    public function countTenantsByHouseId($houseId, $ownerId) {
        $result = $this->table('room_tenants')
            ->select('COUNT(DISTINCT room_tenants.user_id) as count')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.id', $houseId)
            ->where('houses.owner_id', $ownerId)
            ->whereNull('room_tenants.left_date')
            ->first();

        return $result ? (int) $result['count'] : 0;
    }

    /**
     * Đếm số khách thuê đang ở theo house_id
     */
    public function countActiveTenantsByHouseId($houseId, $ownerId) {
        $result = $this->table('room_tenants')
            ->select('COUNT(DISTINCT room_tenants.user_id) as count')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.id', $houseId)
            ->where('houses.owner_id', $ownerId)
            ->whereNull('room_tenants.left_date')
            ->first();

        return $result ? (int) $result['count'] : 0;
    }

    /**
     * Tạo user mới
     */
    public function createUser($userData) {
        // Tạo password mặc định (có thể thay đổi sau)
        $userData['password'] = password_hash('123456', PASSWORD_DEFAULT);

        return $this->table('users')
            ->insert($userData);
    }

    /**
     * Tạo tenant mới
     */
    public function createTenant($tenantData) {
        return $this->queryBuilder
            ->table($this->table)
            ->insert($tenantData);
    }

    /**
     * Kiểm tra email đã tồn tại chưa
     */
    public function checkEmailExists($email) {
        $result = $this->table('users')
            ->select('id')
            ->where('email', $email)
            ->where('deleted', 0)
            ->first();

        return $result ? true : false;
    }

    /**
     * Kiểm tra email có tồn tại và đã active
     */
    public function checkEmailExistsAndActive($email) {
        $result = $this->table('users')
            ->select(['id', 'username', 'account_status'])
            ->where('email', $email)
            ->where('deleted', 0)
            ->where('account_status', 'active')
            ->first();

        return $result ? $result : false;
    }

    /**
     * Kiểm tra phone đã tồn tại chưa
     */
    public function checkPhoneExists($phone) {
        $result = $this->table('users')
            ->select('id')
            ->where('phone', $phone)
            ->where('deleted', 0)
            ->first();

        return $result ? true : false;
    }

    /**
     * Kiểm tra citizen_id đã tồn tại chưa
     */
    public function checkCitizenIdExists($citizenId) {
        if (empty($citizenId)) {
            return false;
        }

        $result = $this->table('users')
            ->select('id')
            ->where('citizen_id', $citizenId)
            ->where('deleted', 0)
            ->first();

        return $result ? true : false;
    }

    /**
     * Kiểm tra user có đang ở phòng khác không (chưa có left_date)
     */
    public function checkUserCurrentlyInRoom($userId) {
        $result = $this->table('room_tenants')
            ->select([
                'room_tenants.id',
                'rooms.room_name',
                'houses.house_name',
                'room_tenants.join_date',
            ])
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('room_tenants.user_id', $userId)
            ->whereNull('room_tenants.left_date')
            ->first();

        return $result ? $result : false;
    }

    /**
     * Kiểm tra email có đang ở phòng khác không
     */
    public function checkEmailCurrentlyInRoom($email) {
        $result = $this->table('users')
            ->select([
                'users.id',
                'users.username',
                'rooms.room_name',
                'houses.house_name',
                'room_tenants.join_date',
            ])
            ->join('room_tenants', 'users.id', '=', 'room_tenants.user_id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('users.email', $email)
            ->where('users.deleted', 0)
            ->whereNull('room_tenants.left_date')
            ->first();

        return $result ? $result : false;
    }

    /**
     * Kiểm tra phone có đang ở phòng khác không
     */
    public function checkPhoneCurrentlyInRoom($phone) {
        $result = $this->table('users')
            ->select([
                'users.id',
                'users.username',
                'rooms.room_name',
                'houses.house_name',
                'room_tenants.join_date',
            ])
            ->join('room_tenants', 'users.id', '=', 'room_tenants.user_id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('users.phone', $phone)
            ->where('users.deleted', 0)
            ->whereNull('room_tenants.left_date')
            ->first();

        return $result ? $result : false;
    }

    /**
     * Kiểm tra citizen_id có đang ở phòng khác không
     */
    public function checkCitizenIdCurrentlyInRoom($citizenId) {
        if (empty($citizenId)) {
            return false;
        }

        $result = $this->table('users')
            ->select([
                'users.id',
                'users.username',
                'rooms.room_name',
                'houses.house_name',
                'room_tenants.join_date',
            ])
            ->join('room_tenants', 'users.id', '=', 'room_tenants.user_id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('users.citizen_id', $citizenId)
            ->where('users.deleted', 0)
            ->whereNull('room_tenants.left_date')
            ->first();

        return $result ? $result : false;
    }

    /**
     * Lấy danh sách phòng có thể thêm người (chưa đầy)
     */
    public function getAvailableRoomsByHouseId($houseId, $ownerId) {
        // Lấy tất cả phòng của nhà
        $allRooms = $this->table('rooms')
            ->select([
                'rooms.id',
                'rooms.room_name',
                'rooms.room_status',
                'rooms.max_people',
            ])
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.id', $houseId)
            ->where('houses.owner_id', $ownerId)
            ->where('rooms.deleted', 0)
            ->orderBy('rooms.room_name', 'ASC')
            ->get();

        // Đếm số khách hiện tại cho mỗi phòng
        $roomsWithCount = [];
        foreach ($allRooms as $room) {
            $currentTenants = $this->reset()->table('room_tenants')
                ->select('COUNT(*) as count')
                ->where('room_id', $room['id'])
                ->whereNull('left_date')
                ->first();

            $currentCount = $currentTenants ? (int) $currentTenants['count'] : 0;
            $maxPeople = (int) $room['max_people'];

            // Chỉ thêm phòng nếu chưa đầy
            if ($currentCount < $maxPeople) {
                $roomsWithCount[] = [
                    'id' => $room['id'],
                    'room_name' => $room['room_name'],
                    'room_status' => $room['room_status'],
                    'max_tenants' => $maxPeople,
                    'current_tenants' => $currentCount,
                ];
            }
        }

        return $roomsWithCount;
    }

    /**
     * Transaction methods
     */
    public function beginTransaction() {
        return $this->beginTransaction();
    }

    public function commit() {
        return $this->commit();
    }

    public function rollback() {
        return $this->rollback();
    }

    /**
     * Cập nhật thông tin khách thuê
     */
    public function updateTenant($tenantId, $userData, $tenantData, $ownerId) {
        try {
            // Bắt đầu transaction
            $this->beginTransaction();

            // Cập nhật thông tin user
            if (!empty($userData)) {
                $userData['updated_at'] = date('Y-m-d H:i:s');
                $this->table('users')
                    ->where('id', $tenantId)
                    ->where('deleted', 0)
                    ->update($userData);
            }

            // Cập nhật thông tin tenant
            if (!empty($tenantData)) {
                $tenantData['updated_at'] = date('Y-m-d H:i:s');
                $this->table('room_tenants')
                    ->where('user_id', $tenantId)
                    ->whereNull('left_date')
                    ->update($tenantData);
            }

            // Commit transaction
            $this->commit();
            return true;

        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            $this->rollback();
            throw $e;
        }
    }

    /**
     * Lấy thông tin khách thuê để edit (bao gồm cả thông tin user và tenant)
     */
    public function getTenantForEdit($tenantId, $ownerId) {
        $result = $this->table('room_tenants')
            ->select([
                'users.id',
                'users.username',
                'users.email',
                'users.phone',
                'users.gender',
                'users.birthday',
                'users.job',
                'users.province',
                'users.ward',
                'users.address',
                'users.citizen_id',
                'rooms.id as room_id',
                'rooms.room_name',
                'houses.id as house_id',
                'houses.house_name',
                'room_tenants.join_date',
                'room_tenants.expected_leave_date',
                'room_tenants.is_primary',
                'room_tenants.note',
            ])
            ->join('users', 'room_tenants.user_id', '=', 'users.id')
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('users.id', $tenantId)
            ->where('houses.owner_id', $ownerId)
            ->where('users.deleted', 0)
            ->where('rooms.deleted', 0)
            ->whereNull('room_tenants.left_date')
            ->first();

        return $result;
    }

    /**
     * Kiểm tra email có bị trùng với user khác không (khi edit)
     */
    public function checkEmailExistsForOtherUser($email, $excludeUserId) {
        $result = $this->table('users')
            ->select('id')
            ->where('email', $email)
            ->where('id', '!=', $excludeUserId)
            ->where('deleted', 0)
            ->first();

        return $result ? true : false;
    }

    /**
     * Kiểm tra phone có bị trùng với user khác không (khi edit)
     */
    public function checkPhoneExistsForOtherUser($phone, $excludeUserId) {
        $result = $this->table('users')
            ->select('id')
            ->where('phone', $phone)
            ->where('id', '!=', $excludeUserId)
            ->where('deleted', 0)
            ->first();

        return $result ? true : false;
    }

    /**
     * Kiểm tra citizen_id có bị trùng với user khác không (khi edit)
     */
    public function checkCitizenIdExistsForOtherUser($citizenId, $excludeUserId) {
        if (empty($citizenId)) {
            return false;
        }

        $result = $this->table('users')
            ->select('id')
            ->where('citizen_id', $citizenId)
            ->where('id', '!=', $excludeUserId)
            ->where('deleted', 0)
            ->first();

        return $result ? true : false;
    }

    /**
     * Execute raw SQL query
     */
    public function query($sql, $params = []) {
        return $this->query($sql, $params);
    }

    // Added by Huy Nguyen get room by user id
    public function getAllRoomByUserId() {
        return $this->table('room_tenants')->where('user_id', $this->userID)->get();
    }

    // Added by Huy Nguyen get detailed rented rooms by user id
    public function getDetailedRentedRoomsByUserId() {
        return $this->table('room_tenants')
            ->select([
                'room_tenants.join_date',
                'rooms.*',
                'houses.house_name',
                'houses.address',
                'houses.province',
                'houses.ward',
                'houses.owner_id',
                'users.username',
                'users.phone',
            ])
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('users', 'houses.owner_id', '=', 'users.id')
            ->where('room_tenants.user_id', $this->userID)
            ->whereNull('room_tenants.left_date')
            ->where('rooms.deleted', 0)
            ->where('houses.deleted', 0)
            ->orderBy('room_tenants.join_date', 'DESC')
            ->get();
    }

    // Added by Huy Nguyen get room detail by id
    public function getRoomDetailById($id) {
        return $this->table('room_tenants')
            ->select([
                'rooms.*',
                'houses.house_name',
                'houses.province',
                'houses.ward',
                'houses.address',
                'houses.owner_id',
            ])
            ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('users', 'room_tenants.user_id', '=', 'users.id')
            ->where('room_tenants.id', $id)
            ->where('room_tenants.user_id', $this->userID)
            ->where('rooms.deleted', 0)
            ->first();
    }

    // Added by Huy Nguyen get current tenants by room id
    public function countCurrentTenantsByRoomId($roomId) {
        return $this->table('room_tenants')
        ->join('rooms', 'room_tenants.room_id', '=', 'rooms.id')
            ->where('room_id', $roomId)
            ->where('rooms.deleted', 0)
            ->count();
    }
}
