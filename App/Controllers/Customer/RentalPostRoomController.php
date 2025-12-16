<?php
/*
 *    Author: Huy Nguyen
 *    Date: 2025-10-06
 *    Purpose: to hanle rental post house page
 */

namespace App\Controllers\Customer;

class RentalPostRoomController extends RentalPostCustomerController {
    protected $titlePage = 'Cho thuê Phòng trọ, nhà trọ giá rẻ ';
    protected $returnPage = 'room';
    protected $primaryFilter = 'Phòng trọ, Nhà trọ, Phòng trọ sinh viên, Nhà trọ sinh viên';

    public function searchByFilter() {
        parent::searchByFilter();
    }
}
