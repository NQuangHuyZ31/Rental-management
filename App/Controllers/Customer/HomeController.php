<?php

/*
	Author: Huy Nguyen
	Date: 2025-08-31
	Purpose: Handle home for customer
*/

namespace App\Controllers\Customer;

use App\Controllers\BaseCustomerController;
use Core\QueryBuilder;
use Core\ViewRender;

class HomeController extends BaseCustomerController {
	protected $title = 'Trang chủ';
	protected $subNav = true;
	protected $queryBuilder;

	public function __construct() {
		parent::__construct();
		$this->queryBuilder = new QueryBuilder();
	}
	
	public function index() {

		$rentalHotDeals = $this->queryBuilder->table('rental_posts')
									->select(['id', 'rental_post_title', 'contact', 'phone', 'price', 'price_discount', 'area', 'province', 'ward', 'image_primary', 'images'])
									->where('deleted', 0)->where('status', 'active')
									->where('approval_status', 'approved')->orderBy('price_discount', 'asc')->limit(8)->get();
		
		$rentalStayNow = $this->queryBuilder->table('rental_posts')
									->select(['id', 'rental_post_title', 'contact', 'phone', 'price', 'price_discount', 'area', 'province', 'ward', 'image_primary', 'images'])
									->where('deleted', 0)->where('status', 'active')
									->where('stay_start_date', '>=', date('Y-m-d'))
									->where('approval_status', 'approved')->limit(8)->get();

		$rentalNewPosts = $this->queryBuilder->table('rental_posts')
									->select(['id', 'rental_post_title', 'contact', 'phone', 'price', 'price_discount', 'area', 'province', 'ward', 'image_primary', 'images'])
									->where('deleted', 0)->where('status', 'active')
									->where('approval_status', 'approved')->orderBy('created_at', 'desc')->limit(10)->get();
		
		ViewRender::renderWithLayout('customer/index', 
		[
			'title' => $this->title, 
			'subNav' => $this->subNav, 
			'rentalHotDeals' => $rentalHotDeals, 
			'rentalStayNow' => $rentalStayNow,
			'rentalNewPosts' => $rentalNewPosts
		]
		,'customer/layouts/app');
	}
}