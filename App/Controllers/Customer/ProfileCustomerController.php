<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-11
 * Purpose: Profile Customer Controller
 */

namespace App\Controllers\Customer;

use App\Controllers\Controller;
use Core\ViewRender;

class ProfileCustomerController extends Controller {
    protected $sidebar = true;
    protected $noFooter = true;
    protected $title = 'Thông tin cá nhân';
	
	public function profile() {
		ViewRender::renderWithLayout(
			'customer/profile',
			[
				'sidebar' => $this->sidebar,
				'noFooter' => $this->noFooter,
				'title' => $this->title,
			],
			'customer/layouts/app'
		);
	}
}
