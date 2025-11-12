<?php 

/*

* Author: Huy Nguyen
* Date: 2025-09-19
* Purpose: Build Admin Controller
*/

namespace App\Controllers\Admin;

use App\Controllers\BaseCustomerController;
use App\Models\RentalCategory;
use App\Models\RenTalPost;
use App\Models\RentalAmenity;
use App\Models\User;
use App\Models\Role;
use App\Models\Banned;
use App\Models\PaymentHistory;
use App\Models\ReportViolation;
use Core\QueryBuilder;

class AdminController extends BaseCustomerController {

	protected $limit = 10;
	protected $userModel;
	protected $rentalCategoryModel;
	protected $rentalAmenityModel;
	protected $roleModel;
	protected $bannedModel;
	protected $queryBuilder;
	protected $paymentHostoryModel;
	protected $reportViolationModel;

	public function __construct() {
		parent::__construct();
		$this->userModel = new User();
		$this->rentalCategoryModel = new RentalCategory();
		$this->rentalAmenityModel = new RentalAmenity();
		$this->roleModel = new Role();
		$this->bannedModel = new Banned();
		$this->queryBuilder = new QueryBuilder();
		$this->paymentHostoryModel = new PaymentHistory();
		$this->reportViolationModel = new ReportViolation();
	}
}