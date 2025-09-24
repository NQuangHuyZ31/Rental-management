<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-19
* Purpose: Helper for data model
*/

namespace Helpers;

use App\Models\RenTalPost;

class DataModelHelper {
	protected $rentalPostModel;

	public function __construct() {
		$this->rentalPostModel = new RenTalPost();
	}

	public function getRentalPostStatus($status) {
		return $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);
	}
}