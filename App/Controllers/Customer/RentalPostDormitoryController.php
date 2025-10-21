<?php
/*
	Author: Huy Nguyen
	Date: 2025-10-21
	Purpose: rental post dormitory
*/

namespace App\Controllers\Customer;

class RentalPostDormitoryController extends RentalPostCustomerController {
    protected $titlePage = 'Cho thuê Ký túc xá, Sleepbox giá rẻ ';
    protected $returnPage = 'dormitory';
    protected $primaryFilter = 'Ký túc xá, Sleepbox';

    public function searchByFilter() {
        parent::searchByFilter();
    }
}
