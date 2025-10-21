<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-19
 * Purpose: Helper for data model
 */

namespace Helpers;

use App\Models\RenTalPost;
use App\Models\RentalPostInterest;
use Core\Session;

class DataModelHelper {
    protected $rentalPostModel;
    protected $rentalPostInterestModel;

    public function __construct() {
        $this->rentalPostModel = new RenTalPost();
        $this->rentalPostInterestModel = new RentalPostInterest();
    }

    public function getRentalPostStatus($status) {
        return $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);
    }

    // Added by Huy Nguyen on 2025-10-20 to get all post interesting by user id
    public function countPostInterestById() {
        if (!Session::get('user')) {
            return 0;
        }

        return count($this->rentalPostInterestModel->getByUserId(Session::get('user')['id'])) ?? 0;
    }
}