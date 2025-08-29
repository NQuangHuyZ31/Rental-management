<?php

use Core\Router;

// User Middleware
use App\Middleware\AuthMiddleware;
use App\Middleware\BlockMiddleware;

// Khởi tạo đối tượng Router
$router = new Router();


// Route test
//$router->get('/test', [TestController::class, 'index']);
// Xử lý request
$router->handleRequest();
