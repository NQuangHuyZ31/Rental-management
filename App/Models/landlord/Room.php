<?php

namespace App\Models\Landlord;

use App\Models\Model;
use Core\QueryBuilder;

class Room extends Model
{
    protected $table = 'rooms';
    
    public function getRoomsByHouseId($houseId)
    {
        $query = new QueryBuilder();
        return $query->table('rooms')->where('house_id', $houseId)->orderBy('room_name')->get();
    }
    
    public function getRoomById($roomId)
    {
        $query = new QueryBuilder();
        return $query->table('rooms')->where('id', $roomId)->first();
    }
    
    public function getRoomsByStatus($houseId, $status)
    {
        $query = new QueryBuilder();
        return $query->table('rooms')
                    ->where('house_id', $houseId)
                    ->where('room_status', $status)
                    ->orderBy('room_name')
                    ->get();
    }
    
    public function getRoomStatistics($houseId)
    {
        $query = new QueryBuilder();
        return $query->table('rooms')
                    ->select(['room_status', 'COUNT(*) as count', 'SUM(room_price) as total_price', 'SUM(deposit) as total_deposit'])
                    ->where('house_id', $houseId)
                    ->groupBy('room_status')
                    ->get();
    }
}

