<?php

// Core

use App\Controllers\Admin\AuthAdminController;
use App\Controllers\AuthController;
use App\Controllers\Customer\HomeController;
use Core\Router;

// Admin Controller
// Landlord Controller
use App\Controllers\Landlord\HouseController;
use App\Controllers\Landlord\RentalPostController;
use App\Controllers\Landlord\ServiceController;
use App\Controllers\Landlord\AmenityController;
use App\Controllers\Landlord\TenantController;
// Customer Controller
use App\Controllers\TestController;
use App\Middleware\AuthAdminMiddleware;
use App\Middleware\AuthLandlordMiddleware;
use App\Middleware\AuthMiddleware;

// Khởi tạo đối tượng Router
$router = new Router();

// =============================================================ROUTER CUSTOMER==================================================
// Route đến trang chủ
$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'showLoginPage']);
$router->get('/register', [AuthController::class, 'showRegisterPage']);
$router->post('/login', [AuthController::class, 'handleLogin']);
$router->post('/register', [AuthController::class, 'handleRegister']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/verify-account', [AuthController::class, 'verifyAccount']);
$router->post('/verify-account', [AuthController::class, 'handleVerifyAccount']);
$router->post('/resend-otp', [AuthController::class, 'handleResendOTP']);

// =============================================================ROUTER ADMIN==================================================
$router->get('/admin', [AuthAdminController::class, 'index'],[AuthAdminMiddleware::class]);
$router->get('/admin/auth/login', [AuthAdminController::class, 'showLoginPage']);
$router->post('/admin/auth/login', [AuthAdminController::class, 'handleLogin']);

// =============================================================ROUTER LANDLORD==================================================
$router->get('/landlord', [HouseController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/house/create', [HouseController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/house/update', [HouseController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/house/delete', [HouseController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/house/get/{id}', [HouseController::class, 'getHouse'],[AuthLandlordMiddleware::class]);

$router->get('/landlord/service', [ServiceController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/service/create', [ServiceController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/service/update', [ServiceController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/service/delete', [ServiceController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/service/get-rooms/{id}', [ServiceController::class, 'getServiceRooms'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/service/usage', [ServiceController::class, 'getUsageByMonth'],[AuthLandlordMiddleware::class]);

$router->get('/landlord/amenity', [AmenityController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/amenity/create', [AmenityController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/amenity/update', [AmenityController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/amenity/delete', [AmenityController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/amenity/get-rooms/{id}', [AmenityController::class, 'getAmenityRooms'],[AuthLandlordMiddleware::class]);

$router->get('/landlord/tenant', [TenantController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/tenant/create', [TenantController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/tenant/edit/{id}', [TenantController::class, 'edit'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/tenant/update', [TenantController::class, 'update'],[AuthLandlordMiddleware::class]);

$router->get('/landlord/post-news', [RentalPostController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/create', [RentalPostController::class, 'create'],[AuthLandlordMiddleware::class]);

// Route test
$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
