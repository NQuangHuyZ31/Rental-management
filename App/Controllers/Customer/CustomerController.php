<?php

/*
Author: Huy Nguyen
Date: 2025-09-13
Purpose: Customer Controller
*/
namespace App\Controllers\Customer;

use App\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Tenant;
use Core\Request;
use Core\Session;

class CustomerController extends Controller {
	protected $invoiceModel;
	protected $tenantModel;
	protected $userID;
	protected $request;

	public function __construct() {
		parent::__construct();
		$this->invoiceModel = new Invoice();
		$this->tenantModel = new Tenant();
		$this->userID = Session::get('user')['id'] ?? '';
		$this->request = new Request();
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