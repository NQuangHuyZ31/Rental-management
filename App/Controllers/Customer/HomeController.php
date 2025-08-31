<?php

/*
	Author: Huy Nguyen
	Date: 2025-08-31
	Purpose: Handle home for customer
*/

namespace App\Controllers\Customer;

use App\Controllers\Controller;
use Core\ViewRender;

class HomeController extends Controller {
	public function index() {
		ViewRender::renderWithLayout('customer/index', [],'customer/layouts/app');
	}
}