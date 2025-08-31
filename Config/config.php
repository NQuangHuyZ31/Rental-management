<?php
// Tách domain ra, chỉ lấy phần path thôi
$parsedUrl = parse_url($_ENV['APP_URL']);

// Nếu có path (ví dụ: /Rental-management), còn không thì để rỗng
$basePath = isset($parsedUrl['path']) ? rtrim($parsedUrl['path'], '/') : '';

// BASE_URL giờ chỉ còn /Rental-management
define('BASE_URL', $basePath);

// Các define khác
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/views/');
define('VIEW_PATH_USER_LAYOUT', $_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/views/user/layout/');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/Public/upload/');
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . BASE_URL);
