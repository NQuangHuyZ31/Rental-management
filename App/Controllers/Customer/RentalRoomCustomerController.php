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
		$rentedRooms = $this->tenantModel->getDetailedRentedRoomsByUserId();

		ViewRender::renderWithLayout(
			'customer/rental-room/rented-rooms',
			[
				'sidebar' => $this->sidebar,
				'noFooter' => $this->noFooter,
				'title' => $this->title,
				'sidebarData' => $this->sidebarData(),
				'rentedRooms' => $rentedRooms,
			],
			'customer/layouts/app'
		);
	}

	public function roomDetail($id) {
		$roomDetail = $this->tenantModel->getRoomDetailById($id, $this->user['id']);

		if (!$roomDetail) {
			$this->request->redirectBackWithError('Phòng không tồn tại');
			return;
		}

		$amenities = $this->amenityModel->getAmenitiesByRoomId($id);
		$currentTenants = $this->tenantModel->countCurrentTenantsByRoomId($id);
		$services = $this->serviceModel->getServicesByRoomId($id);
		$landlordInfor = $this->userModel->getUserById($roomDetail['owner_id']);

		ViewRender::renderWithLayout(
			'customer/rental-room/room-detail',
			[
				'sidebar' => $this->sidebar,
				'noFooter' => $this->noFooter,
				'title' => $this->title,
				'roomDetail' => $roomDetail,
				'amenities' => $amenities,
				'services' => $services,
				'currentTenants' => $currentTenants,
				'landlordInfor' => $landlordInfor,
			],
			'customer/layouts/app'
		);
	}
}