<?php

/*
Author: Huy Nguyen
Date: 2025-09-18
Purpose: Build Profile Landlord Controller
*/

namespace App\Controllers\Landlord;


use App\Controllers\ProfileController;
use Core\ViewRender;

class ProfileLandlordController extends ProfileController {

	public function __construct() {
		parent::__construct();
	}

	public function profile() {
		$user = $this->userModel->getUserById($this->userID);
		return ViewRender::render('landlord/profile/index', [
			'user' => $user
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
}