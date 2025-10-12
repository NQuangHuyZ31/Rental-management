<?php
/*
*	Author: Huy Nguyen
*	Date: 2025-10-06
*	Purpose: to hanle rental post house page
*/
namespace App\Controllers\Customer;

use App\Controllers\Customer\BaseRentalPostController;

class RentalPostHouseController extends BaseRentalPostController {
	protected $titlePage = 'Cho thuê Phòng trọ, nhà trọ giá rẻ ';
	protected $returnPage = 'house';
	protected $primaryFilter = 'phòng trọ, nhà trọ';

	public function searchByFilter() {
		parent::searchByFilter();
	}
}
