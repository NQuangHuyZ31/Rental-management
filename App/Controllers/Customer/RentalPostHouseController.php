<?php
/*
 *    Author: Huy Nguyen
 *    Date: 2025-10-06
 *    Purpose: to hanle rental post house page
 */

namespace App\Controllers\Customer;

class RentalPostHouseController extends RentalPostCustomerController {
    protected $titlePage = 'Cho thuê nhà nguyên căn giá rẻ';
    protected $returnPage = 'house';
    protected $primaryFilter = 'Nhà nguyên căn, nhà nguyên căn, mặt bằng kinh doanh, Mặt bằng cho thuê, cửa hàng';

    public function searchByFilter() {
        parent::searchByFilter();
    }
}
