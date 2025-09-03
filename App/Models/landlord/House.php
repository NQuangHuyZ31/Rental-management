<?php

namespace App\Models\Landlord;

use App\Models\Model;
use Core\QueryBuilder;

class House extends Model
{
    protected $table = 'houses';
    
    public function getHousesByOwnerId($ownerId)
    {
        $query = new QueryBuilder();
        return $query->table('houses')->where('owner_id', $ownerId)->where('deleted', 0)->orderBy('house_name')->get();
    }
    
    public function getHouseById($houseId, $ownerId = null)
    {
        $query = new QueryBuilder();
        $query->table('houses')->where('id', $houseId)->where('deleted', 0);
        
        if ($ownerId) {
            $query->where('owner_id', $ownerId);
        }
        
        return $query->first();
    }
    
    public function getRoomsByHouseId($houseId)
    {
        $query = new QueryBuilder();
        return $query->table('rooms')->where('house_id', $houseId)->orderBy('room_name')->get();
    }
    
    public function getHouseWithRooms($houseId, $ownerId = null)
    {
        $house = $this->getHouseById($houseId, $ownerId);
        if ($house) {
            $house['rooms'] = $this->getRoomsByHouseId($houseId);
        }
        return $house;
    }

    /**
     * Tạo mới nhà trọ
     */
    public function createHouse($data)
    {
        $query = new QueryBuilder();
        return $query->table('houses')->insert($data);
    }

    /**
     * Cập nhật nhà trọ
     */
    public function updateHouse($houseId, $data)
    {
        $query = new QueryBuilder();
        
        // Sử dụng raw SQL với named parameters để tránh lỗi binding
        $sql = "UPDATE houses SET 
                house_name = :house_name, 
                province = :province, 
                ward = :ward, 
                address = :address, 
                payment_date = :payment_date, 
                due_date = :due_date, 
                updated_at = :updated_at 
                WHERE id = :id";
        
        $params = array_merge($data, ['id' => $houseId]);
        
        return $query->query($sql, $params);
    }

    /**
     * Lấy tất cả nhà trọ (bao gồm cả đã xóa) - dành cho admin
     */
    public function getAllHousesByOwnerId($ownerId)
    {
        $query = new QueryBuilder();
        return $query->table('houses')->where('owner_id', $ownerId)->orderBy('house_name')->get();
    }
    
    /**
     * Lấy nhà trọ theo ID (bao gồm cả đã xóa) - dành cho admin
     */
    public function getHouseByIdIncludeDeleted($houseId, $ownerId = null)
    {
        $query = new QueryBuilder();
        $query->table('houses')->where('id', $houseId);
        
        if ($ownerId) {
            $query->where('owner_id', $ownerId);
        }
        
        return $query->first();
    }

    /**
     * Khôi phục nhà trọ đã xóa (soft delete)
     */
    public function restoreHouse($houseId)
    {
        $query = new QueryBuilder();
        
        $sql = "UPDATE houses SET deleted = :deleted, updated_at = :updated_at WHERE id = :id";
        
        $params = [
            'deleted' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
            'id' => $houseId
        ];
        
        return $query->query($sql, $params);
    }

    /**
     * Xóa nhà trọ (soft delete - cập nhật deleted = 1)
     */
    public function deleteHouse($houseId)
    {
        $query = new QueryBuilder();
        
        $sql = "UPDATE houses SET deleted = :deleted, updated_at = :updated_at WHERE id = :id";
        
        $params = [
            'deleted' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
            'id' => $houseId
        ];
        
        return $query->query($sql, $params);
    }
}
