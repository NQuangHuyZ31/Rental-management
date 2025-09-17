<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-05
 * Purpose: Rental Category Model
 */

namespace App\Models;

class RentalCategory extends Model {
    protected $table = 'rental_categories';

    public function getAllRentalCategories($ownerId = true, $system = true, $status = 'active') {

        $sql = "SELECT * FROM rental_categories WHERE deleted = ?";
        $params = [0];

        if ($status) {
            $sql .= " AND rental_category_status = ?";
            $params[] = $status;
        }

        if ($ownerId && $system) {
            $sql .= " AND (owner_id = ? OR owner_id IS NULL)";
            $params[] = $this->getCurrentUserId();
        } elseif ($ownerId && !$system) {
            $sql .= " AND owner_id = ?";
            $params[] = $this->getCurrentUserId();
        } elseif (!$ownerId && $system) {
            $sql .= " AND owner_id IS NULL";
        }

        return $this->queryAll($sql, $params);
    }
    
    public function getRentalCategoryById($id, $ownerId) {
        return $this->table($this->table)->where('id', $id)->where('deleted', 0)->where('owner_id', $ownerId)->first();
    }

    public function createRentalCategory($data) {
        return $this->table($this->table)->insert($data);
    }

    public function updateRentalCategory($id, $data) {
        return $this->table($this->table)->where('id', $id)->update($data);
    }

    public function deleteRentalCategory($id) {
        return $this->table($this->table)->where('id', $id)->update(['deleted' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
    }
}