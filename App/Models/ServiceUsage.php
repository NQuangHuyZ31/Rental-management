<?php
/*
Author: Nguyen Xuan Duong
Date: 2025-08-31
Purpose: Build Service Usage Model
 */
namespace App\Models;

use App\Models\Model;
use Core\QueryBuilder;

class ServiceUsage extends Model {
    protected $table = 'service_usages';
    private $queryBuilder;

    public function __construct() {
        parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Lấy dữ liệu sử dụng dịch vụ theo tháng và nhà
     */
    public function getUsageByMonthAndHouse($houseId, $month, $year) {
        // Format month_year theo format MM-YYYY
        $monthYear = sprintf('%02d-%d', $month, $year);

        $sql = "
            SELECT
                r.id as room_id,
                r.room_name as room_number,
                s.id as service_id,
                s.service_name,
                s.service_type,
                s.service_price,
                s.unit,
                s.unit_vi,
                su.usage_amount,
                su.old_value,
                su.new_value,
                su.total_amount
            FROM rooms r
            INNER JOIN room_services rs ON r.id = rs.room_id
            INNER JOIN services s ON rs.service_id = s.id
            INNER JOIN service_usages su ON (
                r.id = su.room_id
                AND s.id = su.service_id
                AND su.month_year = ?
            )
            WHERE r.house_id = ? AND r.deleted = 0
            ORDER BY r.room_name, s.service_type
        ";

        return $this->queryBuilder->query($sql, [$monthYear, $houseId]);
    }

    /**
     * Lấy dữ liệu sử dụng dịch vụ theo phòng và tháng
     */
    public function getUsageByRoomAndMonth($roomId, $month, $year) {
        // Format month_year theo format MM-YYYY
        $monthYear = sprintf('%02d-%d', $month, $year);

        $sql = "
            SELECT
                s.id as service_id,
                s.service_name,
                s.service_type,
                s.service_price,
                s.unit,
                s.unit_vi,
                COALESCE(su.usage_amount, 0) as usage_amount,
                COALESCE(su.old_value, 0) as old_value,
                COALESCE(su.new_value, 0) as new_value,
                COALESCE(su.total_amount, 0) as total_amount
            FROM services s
            LEFT JOIN room_services rs ON s.id = rs.service_id
            LEFT JOIN service_usages su ON (
                s.id = su.service_id
                AND rs.room_id = su.room_id
                AND su.month_year = ?
            )
            WHERE rs.room_id = ?
            ORDER BY s.service_type
        ";

        return $this->queryBuilder->query($sql, [$monthYear, $roomId]);
    }

    /**
     * Tạo hoặc cập nhật dữ liệu sử dụng dịch vụ
     */
    public function createOrUpdateUsage($data) {
        $sql = "
            INSERT INTO service_usages (room_id, service_id, old_value, new_value, usage_amount, total_amount, month_year, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
            old_value = VALUES(old_value),
            new_value = VALUES(new_value),
            usage_amount = VALUES(usage_amount),
            total_amount = VALUES(total_amount),
            updated_at = NOW()
        ";

        return $this->queryBuilder->query($sql, [
            $data['room_id'],
            $data['service_id'],
            $data['old_value'],
            $data['new_value'],
            $data['usage_amount'],
            $data['total_amount'],
            $data['month_year'],
        ]);
    }

    /**
     * Xóa dữ liệu sử dụng dịch vụ
     */
    public function deleteUsage($roomId, $serviceId, $month, $year) {
        // Format month_year theo format MM-YYYY
        $monthYear = sprintf('%02d-%d', $month, $year);

        $sql = "
            DELETE FROM service_usages
            WHERE room_id = ? AND service_id = ?
            AND month_year = ?
        ";

        return $this->queryBuilder->query($sql, [$roomId, $serviceId, $monthYear]);
    }

    /**
     * Kiểm tra xem đã có dữ liệu sử dụng cho tháng này chưa
     */
    public function hasUsageForMonth($houseId, $month, $year) {
        // Format month_year theo format MM-YYYY
        $monthYear = sprintf('%02d-%d', $month, $year);

        $sql = "
            SELECT COUNT(*) as count
            FROM service_usages su
            JOIN rooms r ON su.room_id = r.id
            WHERE r.house_id = ?
            AND su.month_year = ?
        ";

        $result = $this->queryBuilder->query($sql, [$houseId, $monthYear]);
        return $result && $result[0]['count'] > 0;
    }
}
