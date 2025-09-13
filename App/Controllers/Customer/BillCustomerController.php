<?php

/*
    Author: Huy Nguyen
    Date: 2025-09-11
    Purpose: Bill Customer Controller
*/

namespace App\Controllers\Customer;

use Core\ViewRender;

class BillCustomerController extends CustomerController {
	protected $sidebar = true;
	protected $noFooter = true;
	protected $title = 'Hóa đơn';

	public function __construct() {
		parent::__construct();
	}

	public function bills() {
		ViewRender::renderWithLayout(
			'customer/bills',
			[
				'sidebar' => $this->sidebar,
				'noFooter' => $this->noFooter,
				'title' => $this->title,
				'sidebarData' => $this->sidebarData(),
			],
			'customer/layouts/app'
		);
	}
}