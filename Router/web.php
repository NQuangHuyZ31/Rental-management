<?php

// Core

use App\Controllers\Admin\AuthAdminController;
use App\Controllers\Admin\DashboardAdminController;
use App\Controllers\Admin\PostManagementController;
use App\Controllers\AuthController;
use App\Controllers\Customer\BillCustomerController;
use App\Controllers\Customer\HomeController;
use App\Controllers\Customer\InterestCustomerController;
use App\Controllers\Customer\ProfileCustomerController;
use App\Controllers\Customer\RentalRoomCustomerController;
use Core\Router;

// Admin Controller
// Landlord Controller
use App\Controllers\Landlord\HouseController;
use App\Controllers\Landlord\RoomController;
use App\Controllers\Landlord\RentalPostController;
use App\Controllers\Landlord\ServiceController;
use App\Controllers\Landlord\AmenityController;
use App\Controllers\Landlord\TenantController;
use App\Controllers\Landlord\InvoiceController;
// Customer Controller
use App\Controllers\TestController;
use App\Controllers\Customer\PaymentController;
use App\Controllers\Customer\SettingCustomerController;
use App\Controllers\Landlord\ProfileLandlordController;
use App\Controllers\Landlord\SettingPaymentController;
use App\Controllers\Landlord\SettingPostController;
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

$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordPage']);
$router->post('/send-link-reset-password', [AuthController::class, 'sendLinkResetPassword']);
$router->get('/reset-password', [AuthController::class, 'showResetPasswordPage']);
$router->post('/reset-password', [AuthController::class, 'handleResetPassword']);


// PROFILE
$router->get('/customer/profile', [ProfileCustomerController::class, 'profile'],[AuthMiddleware::class]);
$router->post('/customer/profile/update', [ProfileCustomerController::class, 'update'],[AuthMiddleware::class]);
$router->post('/customer/profile/update-profile-picture', [ProfileCustomerController::class, 'updateProfilePicture'],[AuthMiddleware::class]);
$router->post('/customer/profile/change-password', [ProfileCustomerController::class, 'changePassword'],[AuthMiddleware::class]);
$router->get('/customer/bills', [BillCustomerController::class, 'bills'],[AuthMiddleware::class]);
$router->get('/customer/payment-history', [BillCustomerController::class, 'paymentHistory'],[AuthMiddleware::class]);
$router->get('/customer/interests', [InterestCustomerController::class, 'interests'],[AuthMiddleware::class]);
$router->get('/customer/settings', [SettingCustomerController::class, 'settings'],[AuthMiddleware::class]);
$router->get('/customer/rented-rooms', [RentalRoomCustomerController::class, 'rentedRooms'],[AuthMiddleware::class]);
$router->get('/customer/room-detail/{id}', [RentalRoomCustomerController::class, 'roomDetail'],[AuthMiddleware::class]);
$router->get('/customer/support', [ProfileCustomerController::class, 'support'],[AuthMiddleware::class]);

// =============================================================ROUTER API PAYMENT==================================================
// API thanh toán 
$router->post('/customer/payment', [PaymentController::class, 'payment'],[AuthMiddleware::class]);
$router->post('/customer/payment/callback', [PaymentController::class, 'callback']);
$router->post('/customer/payment/check-status', [PaymentController::class, 'checkPaymentStatus']);

// =============================================================ROUTER ADMIN==================================================
$router->get('/admin', [AuthAdminController::class, 'index'],[AuthAdminMiddleware::class]);
$router->get('/admin/auth/login', [AuthAdminController::class, 'showLoginPage']);
$router->post('/admin/auth/login', [AuthAdminController::class, 'handleLogin']);
$router->get('/admin/auth/logout', [AuthAdminController::class, 'logout']);
$router->get('/admin/dashboard', [DashboardAdminController::class, 'dashboard'],[AuthAdminMiddleware::class]);


// POST MANAGEMENT
$router->get('/admin/posts', [PostManagementController::class, 'index'],[AuthAdminMiddleware::class]);
$router->get('/admin/posts/pending', [PostManagementController::class, 'pendingPostPage'],[AuthAdminMiddleware::class]);
$router->get('/admin/posts/approved', [PostManagementController::class, 'approvedPostPage'],[AuthAdminMiddleware::class]);
$router->get('/admin/posts/rejected', [PostManagementController::class, 'rejectedPostPage'],[AuthAdminMiddleware::class]);

// =============================================================ROUTER LANDLORD==================================================
// House Management Routes
$router->get('/landlord', [HouseController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/house/create', [HouseController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/house/update', [HouseController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/house/delete', [HouseController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/house/get/{id}', [HouseController::class, 'getHouse'],[AuthLandlordMiddleware::class]);

// Room Management Routes
$router->post('/landlord/room/create', [RoomController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/room/update', [RoomController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/room/delete', [RoomController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/room/get/{id}', [RoomController::class, 'getRoom'],[AuthLandlordMiddleware::class]);

// Service Management Routes
$router->get('/landlord/service', [ServiceController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/service/create', [ServiceController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/service/update', [ServiceController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/service/delete', [ServiceController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/service/get-rooms/{id}', [ServiceController::class, 'getServiceRooms'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/service/usage', [ServiceController::class, 'getUsageByMonth'],[AuthLandlordMiddleware::class]);

// Amenity Management Routes
$router->get('/landlord/amenity', [AmenityController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/amenity/create', [AmenityController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/amenity/update', [AmenityController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/amenity/delete', [AmenityController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/amenity/get-rooms/{id}', [AmenityController::class, 'getAmenityRooms'],[AuthLandlordMiddleware::class]);

// Tenant Management Routes
$router->get('/landlord/tenant', [TenantController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/tenant/create', [TenantController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/tenant/edit/{id}', [TenantController::class, 'edit'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/tenant/update', [TenantController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/tenant/delete', [TenantController::class, 'delete'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/tenant/check-before-remove', [TenantController::class, 'checkTenantBeforeRemove'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/tenant/remove', [TenantController::class, 'removeTenant'],[AuthLandlordMiddleware::class]);

// Invoice Management Routes
$router->get('/landlord/invoice', [InvoiceController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/invoice/view/{id}', [InvoiceController::class, 'viewInvoice'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/invoice/update', [InvoiceController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/invoice/updateStatus', [InvoiceController::class, 'updateStatus'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/invoice/mark-as-paid', [InvoiceController::class, 'markAsPaid'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/invoice/create-form/{id}', [InvoiceController::class, 'createForm'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/invoice/create', [InvoiceController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/invoice/delete', [InvoiceController::class, 'delete'],[AuthLandlordMiddleware::class]);


// Rental Post Management Routes
$router->get('/landlord/post-news', [RentalPostController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/create', [RentalPostController::class, 'create'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/posts/get', [RentalPostController::class, 'getPost'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/update', [RentalPostController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/hide', [RentalPostController::class, 'updateStatus'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/posts/delete', [RentalPostController::class, 'delete'],[AuthLandlordMiddleware::class]);

// Setting Payment Management Routes
$router->get('/landlord/setting/payment', [SettingPaymentController::class, 'index'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/setting/payment/update', [SettingPaymentController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/setting/payment-api', [SettingPaymentController::class, 'paymentApi'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/setting/payment/update-api-key', [SettingPaymentController::class, 'updateApiKey'],[AuthLandlordMiddleware::class]);
$router->get('/landlord/setting/payment/guide', [SettingPaymentController::class, 'guide'],[AuthLandlordMiddleware::class]);

// Setting Post Management Routes
$router->get('/landlord/setting/categories', [SettingPostController::class, 'categories'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/setting/categories/create', [SettingPostController::class, 'createCategory'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/setting/categories/delete', [SettingPostController::class, 'deleteCategory'],[AuthLandlordMiddleware::class]);

$router->get('/landlord/setting/amenities', [SettingPostController::class, 'amenities'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/setting/amenities/create', [SettingPostController::class, 'createAmenity'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/setting/amenities/delete', [SettingPostController::class, 'deleteAmenity'],[AuthLandlordMiddleware::class]);

$router->get('/landlord/profile', [ProfileLandlordController::class, 'profile'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/profile/update', [ProfileLandlordController::class, 'update'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/profile/change-password', [ProfileLandlordController::class, 'changePassword'],[AuthLandlordMiddleware::class]);
$router->post('/landlord/profile/update-profile-picture', [ProfileLandlordController::class, 'updateProfilePicture'],[AuthLandlordMiddleware::class]);
// Route test
$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
