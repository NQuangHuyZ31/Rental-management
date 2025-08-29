<?php

// Core

use App\Controllers\AuthController;
use Core\Router;

// Admin Controller
// Landlord Controller
// Customer Controller
use App\Controllers\TestController;
// Khởi tạo đối tượng Router
$router = new Router();

// =============================================================ROUTER CUSTOMER==================================================
// Route đến trang chủ
$router->get('/', [AuthController::class, 'login']);


// =============================================================ROUTER ADMIN==================================================

// =============================================================ROUTER LANDLORD==================================================

// Route test
$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
