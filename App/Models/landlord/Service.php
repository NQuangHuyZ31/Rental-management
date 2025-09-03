<?php

namespace App\Models\Landlord;

use App\Models\Model;
use Core\QueryBuilder;

class Service extends Model
{
    protected $table = 'services';
    
    /**
     * Lấy tất cả dịch vụ của một nhà
     */
    public function getServicesByHouseId($houseId)
    {
        $query = new QueryBuilder();
        return $query->table('services')
                    ->where('house_id', $houseId)
                    ->orderBy('service_name')
                    ->get();
    }
    
    /**
     * Lấy dịch vụ theo ID
     */
    public function getServiceById($serviceId)
    {
        $query = new QueryBuilder();
        return $query->table('services')
                    ->where('id', $serviceId)
                    ->first();
    }
    
    /**
     * Tạo dịch vụ mới
     */
    public function createService($data)
    {
        $query = new QueryBuilder();
        return $query->table('services')->insert($data);
    }
    
    /**
     * Cập nhật dịch vụ
     */
    public function updateService($serviceId, $data)
    {
        $query = new QueryBuilder();
        return $query->table('services')
                    ->where('id', $serviceId)
                    ->update($data);
    }
    
    /**
     * Xóa dịch vụ
     */
    public function deleteService($serviceId)
    {
        $query = new QueryBuilder();
        return $query->table('services')
                    ->where('id', $serviceId)
                    ->delete();
    }
    
    /**
     * Lấy dịch vụ của một phòng cụ thể
     */
    public function getServicesByRoomId($roomId)
    {
        $query = new QueryBuilder();
        return $query->table('room_services')
                    ->select('services.*')
                    ->join('services', 'room_services.service_id', '=', 'services.id')
                    ->where('room_services.room_id', $roomId)
                    ->get();
    }
    
    /**
     * Đếm số phòng áp dụng cho một dịch vụ
     */
    public function getRoomCountByServiceId($serviceId)
    {
        $query = new QueryBuilder();
        $result = $query->table('room_services')
                        ->select('COUNT(*) as count')
                        ->where('service_id', $serviceId)
                        ->first();
        
        return $result ? $result['count'] : 0;
    }
    
    /**
     * Gán dịch vụ cho phòng
     */
    public function assignServiceToRoom($roomId, $serviceId)
    {
        $query = new QueryBuilder();
        return $query->table('room_services')->insert([
            'room_id' => $roomId,
            'service_id' => $serviceId
        ]);
    }
    
    /**
     * Hủy gán dịch vụ cho phòng
     */
    public function unassignServiceFromRoom($roomId, $serviceId)
    {
        $query = new QueryBuilder();
        return $query->table('room_services')
                    ->where('room_id', $roomId)
                    ->where('service_id', $serviceId)
                    ->delete();
    }
    
    /**
     * Lấy lịch sử sử dụng dịch vụ của phòng
     */
    public function getServiceUsageByRoom($roomId, $monthYear = null)
    {
        $query = new QueryBuilder();
        $query->table('service_usages')
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
    public function addServiceUsage($data)
    {
        $query = new QueryBuilder();
        return $query->table('service_usages')->insert($data);
    }
    
    /**
     * Bắt đầu transaction
     */
    public function beginTransaction()
    {
        $query = new QueryBuilder();
        return $query->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit()
    {
        $query = new QueryBuilder();
        return $query->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollback()
    {
        $query = new QueryBuilder();
        return $query->rollback();
    }
}
