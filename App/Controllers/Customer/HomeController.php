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
	protected $title = 'Trang chủ';
	protected $subNav = true;
	
	public function index() {
		ViewRender::renderWithLayout('customer/index', ['title' => $this->title, 'subNav' => $this->subNav],'customer/layouts/app');
	}
}