<?php
// Tách domain ra, chỉ lấy phần path thôi
$parsedUrl = parse_url($_ENV['APP_URL']);
$rootPath = $_ENV['ROOT_SITE_URL'];
// Nếu có path (ví dụ: /Rental-management), còn không thì để rỗng
$basePath = isset($parsedUrl['path']) ? rtrim($parsedUrl['path'], '/') : '';

// BASE_URL giờ chỉ còn /Rental-management
define('APP_URL', $_ENV['APP_URL']);
define('BASE_URL', $basePath);
define('ROOT_PATH', $rootPath);
// Các define khác
define('VIEW_PATH', ROOT_PATH . '/views/');
define('VIEW_PATH_USER_LAYOUT', ROOT_PATH . '/views/user/layout/');
define('UPLOAD_DIR', ROOT_PATH . '/Public/upload/');
define('URL_IMAGE', ROOT_PATH . '/Public/images/');

define('CLOUD_NAME', $_ENV['CLOUD_NAME']);
define('CLOUD_API_KEY', $_ENV['CLOUD_API_KEY']);
define('CLOUD_API_SECRET', $_ENV['CLOUD_API_SECRET']);

define('ACCOUNT_BANK_NUMBER', $_ENV['ACCOUNT_BANK_NUMBER']);
define('ACCOUNT_BANK_CODE', $_ENV['ACCOUNT_BANK_CODE']);
define('ACCOUNT_SECRET_KEY', $_ENV['ACCOUNT_SECRET_KEY']);
define('ACCOUNT_BANK_NAME', $_ENV['ACCOUNT_BANK_NAME']);