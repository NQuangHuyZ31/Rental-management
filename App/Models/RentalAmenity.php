<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-05
 * Purpose: Rental Amenity Model
 */

namespace App\Models;

class RentalAmenity extends Model {
    protected $table = 'rental_amenities';

    public function getAllRentalAmenities($ownerId = true, $system = true, $status = 'active') {
        $sql = "SELECT * FROM rental_amenities WHERE deleted = ?";
        $params = [0];

        if ($status) {
            $sql .= " AND rental_amenity_status = ?";
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

    public function getRentalAmenityById($id = [], $ownerId) {

        if (!is_array($id)) {
            return;
        }

        $query = $this->table($this->table)->whereIn('id', $id)->where('deleted', 0);

        if ($ownerId) {
            $query->where('owner_id', $ownerId);
        }
        return $query->get();
    }

    public function createRentalAmenity($data) {
        return $this->table($this->table)->insert($data);
    }

    public function updateRentalAmenity($id, $data) {
        return $this->table($this->table)->where('id', $id)->update($data);
    }

    public function deleteRentalAmenity($id) {
        return $this->table($this->table)->where('id', $id)->update(['deleted' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
    }
    
	/**
	 * Return array of admin user ids
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