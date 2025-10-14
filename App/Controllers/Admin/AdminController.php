<?php 

/*

* Author: Huy Nguyen
* Date: 2025-09-19
* Purpose: Build Admin Controller
*/

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\RentalCategory;
use App\Models\RenTalPost;
use App\Models\User;
use App\Models\Role;
use Core\QueryBuilder;
use Core\Request;
use Core\Session;

class AdminController extends Controller {
	protected $userModel;
	protected $rentalPostModel;
	protected $rentalCategoryModel;
	protected $roleModel;
	protected $request;
	protected $userID;
	protected $queryBuilder;

	public function __construct() {
		parent::__construct();
		$this->userModel = new User();
		$this->rentalPostModel = new RenTalPost();
		$this->rentalCategoryModel = new RentalCategory();
		$this->roleModel = new \App\Models\Role();
		$this->request = new Request();
		$this->userID = Session::get('user')['id'] ?? '';
		$this->queryBuilder = new QueryBuilder();
	}
}