<?php

// Core
use Core\Router;

// Admin Controller
// Landlord Controller
// Customer Controller
use App\Controllers\TestController;
use App\Controllers\Customer\HomeController;
// Khởi tạo đối tượng Router
$router = new Router();

// =============================================================ROUTER CUSTOMER==================================================
// Route đến trang chủ
$router->get('/', [HomeController::class, 'index']);


// =============================================================ROUTER ADMIN==================================================

// =============================================================ROUTER LANDLORD==================================================

// Route test
$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
