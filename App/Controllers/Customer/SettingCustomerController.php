<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-23
* Purpose: Setting Customer Controller
*/

namespace App\Controllers\Customer;

use App\Controllers\Customer\CustomerController;
use Core\ViewRender;

class SettingCustomerController extends CustomerController {
	protected $sidebar = true;
	protected $noFooter = true;
	protected $title = 'Cài đặt';

	public function settings() {
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
