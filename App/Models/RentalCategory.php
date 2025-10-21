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
            if ($this->getCurrentUserId() != 1) {
                $sql .= " AND (owner_id = ? OR owner_id IS NULL)";
                $params[] = $this->getCurrentUserId();
            }
        } elseif ($ownerId && !$system) {
            $sql .= " AND owner_id = ?";
            $params[] = $this->getCurrentUserId();
        } elseif (!$ownerId && $system) {
            $sql .= " AND owner_id IS NULL";
        }

        return $this->queryAll($sql, $params);
    }

    public function getRentalCategoryById($id, $ownerId) {
        $query = $this->table($this->table)->where('id', $id)->where('deleted', 0);

        if ($ownerId) {
            $query->where('owner_id', $ownerId);
        }

        return $query->first();
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

    /**
     * Author: Nguyen Xuan Duong
     * Date: 2025-10-17
     * Purpose: Get admin user IDs
     * Return array of admin user ids
     * Used by controllers to classify system-owned categories
     */
    public function getAdminUserIds() {
        $admins = $this->table('users')
            ->select('users.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.role_name', '=', 'admin')
            ->get();
        return array_map(function($u) { return (int)$u['id']; }, $admins);
    }
}