<?php

/*
	Author: Huy Nguyen
	Date: 2025-08-31
	Purpose: Handle home for customer
*/

namespace App\Controllers\Customer;

use Core\QueryBuilder;
use App\Controllers\Controller;
use Core\ViewRender;
use App\models\RenTalPost;

class HomeController extends Controller {
	protected $title = 'Trang chủ';
	protected $subNav = true;
	protected $rentalPost;
	protected $queryBuilder;

	public function __construct() {
		parent::__construct();
		$this->rentalPost = new RenTalPost();
		$this->queryBuilder = new QueryBuilder();
	}
	
	public function index() {

		$rentalHotDeals = $this->queryBuilder->table('rental_posts')
									->select(['id', 'rental_post_title', 'contact', 'phone', 'price', 'price_discount', 'area', 'province', 'ward', 'image_primary', 'images'])
									->where('deleted', 0)->where('status', 'active')
									->where('approval_status', 'approved')->orderBy('price_discount', 'asc')->limit(8)->get();
		ViewRender::renderWithLayout('customer/index', ['title' => $this->title, 'subNav' => $this->subNav, 'rentalHotDeals' => $rentalHotDeals],'customer/layouts/app');
	}
}