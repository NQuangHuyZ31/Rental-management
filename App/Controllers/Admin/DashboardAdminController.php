<?php

/*

    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Controller for dashboard admin
*/

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Core\ViewRender;

class DashboardAdminController extends Controller
{
    public function dashboard()
    {
        ViewRender::renderWithLayout('admin/index',[],'admin/layouts/app');
    }
}