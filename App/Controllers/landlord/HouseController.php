<?php

namespace App\Controllers\Landlord;

use App\Controllers\Controller;
use Core\ViewRender;

class HouseController extends Controller
{
    public function index()
    {
        ViewRender::render('landlord/index');
    }
}
?>