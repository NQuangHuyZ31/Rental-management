<?php 

/*

* Author: Huy Nguyen
* Date: 2025-09-05
* Purpose: Rental Amenity Model
*/

namespace App\Models;

class RentalAmenity extends Model {
	protected $table = 'rental_amenities';

	public function getAllRentalAmenities() {
		return $this->table($this->table)->whereOr('deleted', 0)->whereOr('owner_id', $this->getCurrentUserId())->where('rental_amenity_status', 'active')->get();
	}
}