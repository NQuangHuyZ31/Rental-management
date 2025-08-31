<?php

/*
	Author: Nguyen Xuan Duong
	Date: 2025-08-29
	Purpose: Build House Controller
*/

namespace App\Controllers\Landlord;

use App\Controllers\Controller;
use Core\ViewRender;
use Core\QueryBuilder;

class HouseController extends Controller
{
    public function index()
    {
        $query = new QueryBuilder();
        $sql = "SELECT * FROM houses";
        $result = $query->queryAll($sql);
        ViewRender::render('landlord/index', ['houses' => $result]);
    }

    
    
}
?>