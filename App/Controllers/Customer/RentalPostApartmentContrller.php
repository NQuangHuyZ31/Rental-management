<?php
/*
 *    Author: Huy Nguyen
 *    Date: 2025-10-06
 *    Purpose: to hanle rental post apartment page
 */

namespace App\Controllers\Customer;

class RentalPostRoomController extends RentalPostCustomerController {
    protected $titlePage = 'Cho thuê căn hộ, chung cư giá rẻ ';
    protected $returnPage = 'apartment';
    protected $primaryFilter = 'Căn hộ mini, chung cư, Homestay, Nhà nghỉ';

    public function searchByFilter() {
        parent::searchByFilter();
    }
}
