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
use Core\QueryBuilder;
use Core\Request;
use Core\Session;

class AdminController extends Controller {

	protected $limit = 10;
	protected $userModel;
	protected $rentalPostModel;
	protected $rentalCategoryModel;
	protected $rentalAmenityModel;
	protected $roleModel;
	protected $request;
	protected $userID;
	protected $queryBuilder;

	public function __construct() {
		parent::__construct();
		$this->userModel = new User();
		$this->rentalPostModel = new RenTalPost();
		$this->rentalCategoryModel = new RentalCategory();
		$this->rentalAmenityModel = new \App\Models\RentalAmenity();
		$this->roleModel = new \App\Models\Role();
		$this->request = new Request();
		$this->userID = Session::get('user')['id'] ?? '';
		$this->queryBuilder = new QueryBuilder();
	}

	public function getPagination($page, $totalData, $limit, $offset) {
		$totalPages = ceil($totalData / $limit);
		return [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalData,
            'items_per_page' => $limit,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
            'prev_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null,
			'showing_from' => $offset + 1,
            'showing_to' => min($offset + $limit, $totalData)
        ];  
	}
}