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
}