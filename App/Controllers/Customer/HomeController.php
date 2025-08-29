<?php

/*
	name: HomeController
	Author: Huy Nguyen
	Date: 2025-08-28
*/
namespace App\Controllers\Customer;
use App\Controllers\Controller;
use Helpers\ViewHelper;

class HomeController extends Controller{
	
    public function index(){
		$data = [
			'title' => 'Trang chủ',
			'description' => 'Trang chủ của website',
			'keywords' => 'trang chủ, website',
			'author' => 'Huy Nguyen',
			'date' => '2025-08-28'
		];

        ViewHelper::render('customer/index', $data);
    }
}
?>