<?php
/*
 *    Author: Huy Nguyen
 *    Date: 2025-10-06
 *    Purpose: to hanle rental post house page
 */

namespace App\Controllers\Customer;

class RentalPostOfficeController extends RentalPostCustomerController {
    protected $titlePage = 'Cho thuê Văn phòng giá rẻ ';
    protected $returnPage = 'office';
    protected $primaryFilter = 'Văn phòng, Chung cư';

    public function searchByFilter() {
        parent::searchByFilter();
    }
}
