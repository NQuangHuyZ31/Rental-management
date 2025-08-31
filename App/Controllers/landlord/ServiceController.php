<?php
/*
	Author: Nguyen Xuan Duong
	Date: 2025-08-31
	Purpose: Build Service Controller
*/
namespace App\Controllers\Landlord;

use App\Controllers\Controller;
use Core\ViewRender;
use Core\QueryBuilder;

class ServiceController extends Controller
{
    public function index()
    {
        ViewRender::render('landlord/service/index');
    }
}