<?php

/*
Author: Huy Nguyen
Date: 2025-09-13
Purpose: Customer Controller
 */
namespace App\Controllers\Customer;

use App\Controllers\BaseCustomerController;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\Amenity;
use App\Models\Service;
use App\Models\PaymentHistory;
use App\Models\User;
use Core\Session;

class CustomerController extends BaseCustomerController {

    protected $invoiceModel;
    protected $tenantModel;
    protected $amenityModel;
    protected $serviceModel;
    protected $paymentHistoryModel;
    protected $userModel;
    protected $user;

    public function __construct() {
        parent::__construct();
        $this->invoiceModel = new Invoice();
        $this->tenantModel = new Tenant();
        $this->amenityModel = new Amenity();
        $this->serviceModel = new Service();
        $this->paymentHistoryModel = new PaymentHistory();
        $this->userModel= new User();
        $this->user = Session::get('user');
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