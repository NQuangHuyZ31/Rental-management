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
    protected $primaryFilter = 'Căn hộ mini, chung cư, Homestay, Nhà nghỉ, Khách sạn, mặt bằng kinh doanh, Mặt bằng cho thuê, Mặt bằng kinh doanh';

    public function searchByFilter() {
        parent::searchByFilter();
    }
}
