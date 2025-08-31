<?php

// Core

use App\Controllers\Admin\AuthAdminController;
use App\Controllers\AuthController;
use App\Controllers\Customer\HomeController;
use Core\Router;

// Admin Controller
// Landlord Controller
use App\Controllers\Landlord\HouseController;
use App\Controllers\Landlord\ServiceController;
// Customer Controller
use App\Controllers\TestController;
use App\Middleware\AuthAdminMiddleware;
use App\Middleware\AuthLandlordMiddleware;
use App\Middleware\AuthMiddleware;

// Khởi tạo đối tượng Router
$router = new Router();

// =============================================================ROUTER CUSTOMER==================================================
// Route đến trang chủ
$router->get('/', [HomeController::class, 'index'], [AuthMiddleware::class]);

$router->get('/login', [AuthController::class, 'showLoginPage']);
$router->get('/register', [AuthController::class, 'showRegisterPage']);
$router->post('/login', [AuthController::class, 'handleLogin']);
$router->post('/register', [AuthController::class, 'handleRegister']);
$router->get('/logout', [AuthController::class, 'logout']);

// =============================================================ROUTER ADMIN==================================================
$router->get('/admin', [AuthAdminController::class, 'index'],[AuthAdminMiddleware::class]);
$router->get('/admin/auth/login', [AuthAdminController::class, 'showLoginPage']);
$router->post('/admin/auth/login', [AuthAdminController::class, 'handleLogin']);

// =============================================================ROUTER LANDLORD==================================================
$router->get('/landlord', [HouseController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/service', [ServiceController::class, 'index'],[AuthLandlordMiddleware::class]);

// Route test
//$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
