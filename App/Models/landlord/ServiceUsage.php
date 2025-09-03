<?php
/*
    Author: Nguyen Xuan Duong
    Date: 2025-08-31
    Purpose: Build Service Usage Model
*/
namespace App\Models\Landlord;

use App\Models\Model;

class ServiceUsage extends Model
{
    protected $table = 'service_usages';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Lấy dữ liệu sử dụng dịch vụ theo tháng và nhà
     */
    public function getUsageByMonthAndHouse($houseId, $month, $year)
    {
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
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$monthYear, $houseId]);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            return $result;
        } catch (\PDOException $e) {
            error_log("Error in getUsageByMonthAndHouse: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy dữ liệu sử dụng dịch vụ theo phòng và tháng
     */
    public function getUsageByRoomAndMonth($roomId, $month, $year)
    {
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
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$monthYear, $roomId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in getUsageByRoomAndMonth: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Tạo hoặc cập nhật dữ liệu sử dụng dịch vụ
     */
    public function createOrUpdateUsage($data)
    {
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
        
        try {
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute([
                $data['room_id'],
                $data['service_id'],
                $data['old_value'],
                $data['new_value'],
                $data['usage_amount'],
                $data['total_amount'],
                $data['month_year']
            ]);
            
            return $result;
        } catch (\PDOException $e) {
            error_log("Error in createOrUpdateUsage: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Xóa dữ liệu sử dụng dịch vụ
     */
    public function deleteUsage($roomId, $serviceId, $month, $year)
    {
        // Format month_year theo format MM-YYYY
        $monthYear = sprintf('%02d-%d', $month, $year);
        
        $sql = "
            DELETE FROM service_usages 
            WHERE room_id = ? AND service_id = ? 
            AND month_year = ?
        ";
        
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([$roomId, $serviceId, $monthYear]);
        } catch (\PDOException $e) {
            error_log("Error in deleteUsage: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Kiểm tra xem đã có dữ liệu sử dụng cho tháng này chưa
     */
    public function hasUsageForMonth($houseId, $month, $year)
    {
        // Format month_year theo format MM-YYYY
        $monthYear = sprintf('%02d-%d', $month, $year);
        
        $sql = "
            SELECT COUNT(*) as count
            FROM service_usages su
            JOIN rooms r ON su.room_id = r.id
            WHERE r.house_id = ? 
            AND su.month_year = ?
        ";
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$houseId, $monthYear]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (\PDOException $e) {
            error_log("Error in hasUsageForMonth: " . $e->getMessage());
            return false;
        }
    }
}
