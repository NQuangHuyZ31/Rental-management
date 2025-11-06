<?php

/*
Author: Huy Nguyen
Date: 2025-09-18
Purpose: Build Profile Landlord Controller
*/

namespace App\Controllers\Landlord;


use App\Controllers\ProfileController;
use App\Models\House;
use App\Models\Room;
use Core\ViewRender;
use Helpers\Format;

class ProfileLandlordController extends ProfileController {
	protected $houseModel;
	protected $roomModel;

	public function __construct() {
		parent::__construct();
		$this->houseModel = new House();
		$this->roomModel = new Room();
	}

	public function profile() {
		$user = $this->userModel->getUserById($this->userID);
		$houses = $this->houseModel->getHousesByOwnerId($this->user['id']);
		$rooms = $this->roomModel->getAllRoomsByUserId($this->user['id']);
		$totalRentalRoom = 0;

		foreach ($houses as $house) {
			$rentalRoom = $this->roomModel->getAvailableRoomsByHouseId($house['id'], 'occupied');
			$totalRentalRoom += count($rentalRoom);
		}

		$totalRevenue = $this->paymentHistoryModel->getTotalPaymentHistoryByUserId($this->user['id'], 'receiver_id');

		return ViewRender::render('landlord/profile/index', [
			'user' => $user,
			'totalHouse' => count($houses),
			'totalRoom' => count($rooms),
			'totalRentalRoom' => $totalRentalRoom,
			'totalRevenue' => Format::forMatPrice($totalRevenue['total'])
		]);
	}

	public function update() {
		parent::update();
	}

	public function changePassword() {
		parent::changePassword();
	}

	public function updateProfilePicture() {
		parent::updateProfilePicture();
	}

	public function handleDeleteAccount() {
        parent::handleDeleteAccount();
    }
}