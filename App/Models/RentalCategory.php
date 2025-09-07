<?php 

/*

* Author: Huy Nguyen
* Date: 2025-09-05
* Purpose: Rental Category Model
*/

namespace App\Models;

class RentalCategory extends Model {
	protected $table = 'rental_categories';

	public function getAllRentalCategories() {
		return $this->table($this->table)->whereOr('deleted', 0)->whereOr('owner_id', $this->getCurrentUserId())->where('rental_category_status', 'active')->get();
	}
}