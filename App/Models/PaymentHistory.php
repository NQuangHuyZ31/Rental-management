<?php
/*
* Author: Huy Nguyen
* Date: 2025-09-17
* Purpose: Payment History Model
*/

namespace App\Models;

use App\Models\Model;

class PaymentHistory extends Model {
    protected $table = 'payment_histories';

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        return $this->insert($data);
    }

}
