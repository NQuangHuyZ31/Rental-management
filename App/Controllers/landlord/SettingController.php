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
	
    protected $request;
	protected $userID;
	protected $userBanking;
	protected $rentalCategory;
	protected $rentalAmenity;

    public function __construct() {
        parent::__construct();
		$this->request = new Request();
		$this->userID = Session::get('user')['id'] ?? '';
		$this->userBanking = new UserBanking();
		$this->rentalCategory = new RentalCategory();
		$this->rentalAmenity = new RentalAmenity();
    }

	public function index() {
		return ViewRender::render('landlord/settings/index');
	}
}