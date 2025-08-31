<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load file .env trước
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Sau khi $_ENV có dữ liệu rồi mới require config.php
require_once 'Config/config.php';

ob_start(); // Bắt đầu output buffering

// Ẩn các lỗi Deprecated, Notice, Warning
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);

// Nếu cần log lỗi, bật log riêng (tùy chọn)
ini_set('log_errors', 1);
ini_set('error_log', ROOT_PATH . '/Logs/server.log');

// Autoloader để tự động tải class
spl_autoload_register(function ($class) {
    $classPath = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($classPath)) {
        require_once $classPath;
    } else {
        die("Không tìm thấy file: $classPath");
    }
});

// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Routes
require_once __DIR__ . '/Router/web.php';
