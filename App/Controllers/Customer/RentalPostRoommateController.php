<?php

/*
	Author: Huy Nguyen
	Date: 2025-10-21
	Purpose: roommate search
*/

namespace App\Controllers\Customer;

class RentalPostRoommateController extends RentalPostCustomerController {
	protected $titlePage = 'Ở ghép, pass phòng';
    protected $returnPage = 'roommate';
    protected $primaryFilter = 'Ở ghép, Pass phòng, Tìm bạn ở ghép, phòng trọ';

    public function searchByFilter() {
        parent::searchByFilter();
    }
}