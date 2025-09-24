<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-23
* Purpose: Interest Customer Controller
*/

namespace App\Controllers\Customer;

use App\Controllers\Customer\CustomerController;
use Core\ViewRender;

class InterestCustomerController extends CustomerController {
	protected $sidebar = true;
	protected $noFooter = true;
	protected $title = 'Quan tâm';

	public function interests() {
		ViewRender::renderWithLayout(
			'developer-page',
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
