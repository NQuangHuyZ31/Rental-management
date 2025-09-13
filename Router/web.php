<?php

// Core

use App\Controllers\Admin\AuthAdminController;
use App\Controllers\Admin\DashboardAdminController;
use App\Controllers\Admin\PostManagementController;
use App\Controllers\AuthController;
use App\Controllers\Customer\BillCustomerController;
use App\Controllers\Customer\HomeController;
use App\Controllers\Customer\ProfileCustomerController;
use App\Controllers\Customer\RentalRoomCustomerController;
use Core\Router;

// Admin Controller
// Landlord Controller
use App\Controllers\Landlord\HouseController;
use App\Controllers\Landlord\RentalPostController;
use App\Controllers\Landlord\ServiceController;
use App\Controllers\Landlord\AmenityController;
use App\Controllers\Landlord\TenantController;
use App\Controllers\Landlord\InvoiceController;
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


// PROFILE
$router->get('/customer/profile', [ProfileCustomerController::class, 'profile'],[AuthMiddleware::class]);
$router->get('/customer/bills', [BillCustomerController::class, 'bills'],[AuthMiddleware::class]);
$router->get('/customer/notifications', [ProfileCustomerController::class, 'notifications'],[AuthMiddleware::class]);
$router->get('/customer/settings', [ProfileCustomerController::class, 'settings'],[AuthMiddleware::class]);
$router->get('/customer/rented-rooms', [RentalRoomCustomerController::class, 'rentedRooms'],[AuthMiddleware::class]);
$router->get('/customer/room-detail/{id}', [RentalRoomCustomerController::class, 'roomDetail'],[AuthMiddleware::class]);
$router->get('/customer/favorites', [ProfileCustomerController::class, 'favorites'],[AuthMiddleware::class]);
$router->get('/customer/notifications', [ProfileCustomerController::class, 'notifications'],[AuthMiddleware::class]);

// =============================================================ROUTER ADMIN==================================================
$router->get('/admin', [AuthAdminController::class, 'index'],[AuthAdminMiddleware::class]);
$router->get('/admin/auth/login', [AuthAdminController::class, 'showLoginPage']);
$router->post('/admin/auth/login', [AuthAdminController::class, 'handleLogin']);
$router->get('/admin/auth/logout', [AuthAdminController::class, 'logout']);
$router->get('/admin/dashboard', [DashboardAdminController::class, 'dashboard'],[AuthAdminMiddleware::class]);


// POST MANAGEMENT
$router->get('/admin/posts', [PostManagementController::class, 'index'],[AuthAdminMiddleware::class]);

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

$router->get('/landlord/invoice', [InvoiceController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/invoice/getInvoicesByMonth', [InvoiceController::class, 'getInvoicesByMonth'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/invoice/updateStatus', [InvoiceController::class, 'updateStatus'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/invoice/getRentedRooms', [InvoiceController::class, 'getRentedRooms'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/invoice/getRoomServices', [InvoiceController::class, 'getRoomServices'],[AuthLandlordMiddleware::class]);

$router->get('/landlord/post-news', [RentalPostController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/create', [RentalPostController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/posts/get', [RentalPostController::class, 'getPost'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/update', [RentalPostController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/hide', [RentalPostController::class, 'updateStatus'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/delete', [RentalPostController::class, 'delete'],[AuthLandlordMiddleware::class]);

// Route test
$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
