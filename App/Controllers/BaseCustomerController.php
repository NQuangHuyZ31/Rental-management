<?php
/*
	Author: Huy Nguyen
	Date: 2025-08-15
	Purpose: base customer controller
*/
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\RenTalPost;
use Core\Request;

class BaseCustomerController extends Controller {

	protected $request;
	protected $rentalPostModel;

	public function __construct() {
		parent::__construct();
		$this->request = new Request();
		$this->rentalPostModel = new RenTalPost();
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