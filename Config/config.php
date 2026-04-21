<?php
// Tách domain ra, chỉ lấy phần path thôi
$parsedUrl = parse_url($_ENV['APP_URL'] ?? 'https://hosty.up.railway.app');
$basePath = isset($parsedUrl['path']) ? rtrim($parsedUrl['path'], '/') : '';

// BASE_URL for frontend links
define('BASE_URL', $basePath);
define('APP_URL', $_ENV['APP_URL'] ?? 'https://hosty.up.railway.app');

// ROOT_PATH for backend filesystem operations
define('ROOT_PATH', dirname(__DIR__));
// Các define khác
define('VIEW_PATH', ROOT_PATH . '/views/');
define('VIEW_PATH_USER_LAYOUT', ROOT_PATH . '/views/user/layout/');
define('UPLOAD_DIR', ROOT_PATH . '/public/upload/');
define('URL_IMAGE', ROOT_PATH . '/public/images/');

define('CLOUD_NAME', $_ENV['CLOUD_NAME'] ?? null);
define('CLOUD_API_KEY', $_ENV['CLOUD_API_KEY'] ?? null);
define('CLOUD_API_SECRET', $_ENV['CLOUD_API_SECRET'] ?? null);

define('ACCOUNT_BANK_NUMBER', $_ENV['ACCOUNT_BANK_NUMBER'] ?? null);
define('ACCOUNT_BANK_CODE', $_ENV['ACCOUNT_BANK_CODE'] ?? null);
define('ACCOUNT_SECRET_KEY', $_ENV['ACCOUNT_SECRET_KEY'] ?? null);
define('ACCOUNT_BANK_NAME', $_ENV['ACCOUNT_BANK_NAME'] ?? null);