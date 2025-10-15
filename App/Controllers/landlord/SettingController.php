<?php
/*
Author: Huy Nguyen
Date: 2025-09-17
Purpose: Build Setting Controller
 */
namespace App\Controllers\Landlord;

use App\Controllers\Landlord\LandlordController;
use App\Models\RentalCategory;
use App\Models\RentalAmenity;
use App\Models\UserBanking;
use Core\ViewRender;
use Core\Request;
use Core\Session;

class SettingController extends LandlordController {
	
	protected $userBanking;

    public function __construct() {
        parent::__construct();
		$this->userBanking = new UserBanking();
    }

	public function index() {
		return ViewRender::render('landlord/settings/index');
	}
}