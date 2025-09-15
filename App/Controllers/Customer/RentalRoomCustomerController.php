<?php

/*
    Author: Huy Nguyen
    Date: 2025-09-11
    Purpose: Rental Room Customer Controller
*/

namespace App\Controllers\Customer;

use App\Controllers\Customer\CustomerController;
use Core\ViewRender;

class RentalRoomCustomerController extends CustomerController {
	protected $sidebar = true;
	protected $noFooter = true;
	protected $title = 'Phòng đang thuê';

	public function rentedRooms() {
		ViewRender::renderWithLayout(
			'customer/rented-rooms',
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