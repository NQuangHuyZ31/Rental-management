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
	protected $request;
	protected $userID;
	protected $queryBuilder;

	public function __construct() {
		parent::__construct();
		$this->userModel = new User();
		$this->rentalPostModel = new RenTalPost();
		$this->rentalCategoryModel = new RentalCategory();
		$this->request = new Request();
		$this->userID = Session::get('user')['id'] ?? '';
		$this->queryBuilder = new QueryBuilder();
	}

	public function calculatePagination($totalItems, $currentPage, $itemsPerPage) {
        $totalPages = ceil($totalItems / $itemsPerPage);
        
        return [
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'total_items' => $totalItems,
            'items_per_page' => $itemsPerPage,
            'has_prev' => $currentPage > 1,
            'has_next' => $currentPage < $totalPages,
            'prev_page' => $currentPage > 1 ? $currentPage - 1 : 1,
            'next_page' => $currentPage < $totalPages ? $currentPage + 1 : $totalPages
        ];
    }
}