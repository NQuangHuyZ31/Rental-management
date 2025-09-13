<?php

/*
Author: Huy Nguyen
Date: 2025-09-13
Purpose: Customer Controller
*/
namespace App\Controllers\Customer;

use App\Controllers\Controller;
use App\Models\Invoice;

class CustomerController extends Controller {
	protected $invoiceModel;

	public function __construct() {
		parent::__construct();
		$this->invoiceModel = new Invoice();
	}

	public function sidebarData() {
		$invoicePending = $this->invoiceModel->getByStatus('pending');
		return [
			'invoicePending' => count($invoicePending),
		];
	}
	
}