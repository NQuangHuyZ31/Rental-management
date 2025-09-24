<?php

/*
Author: Huy Nguyen
Date: 2025-09-13
Purpose: Customer Controller
 */
namespace App\Controllers\Customer;

use App\Controllers\ProfileController;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\Amenity;
use App\Models\Service;
use App\Models\PaymentHistory;

class CustomerController extends ProfileController {

    protected $invoiceModel;
    protected $tenantModel;
    protected $amenityModel;
    protected $serviceModel;
    protected $paymentHistoryModel;

    public function __construct() {
        parent::__construct();
        $this->invoiceModel = new Invoice();
        $this->tenantModel = new Tenant();
        $this->amenityModel = new Amenity();
        $this->serviceModel = new Service();
        $this->paymentHistoryModel = new PaymentHistory();
    }

    public function sidebarData() {
        $invoicePending = $this->invoiceModel->getAllInvoicesByStatus('pending');
        $room = $this->tenantModel->getAllRoomByUserId();

        return [
            'invoicePending' => count($invoicePending),
            'room' => count($room),
        ];
    }

}