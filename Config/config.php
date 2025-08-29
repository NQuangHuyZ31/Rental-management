<?php
define('BASE_PATH', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE_PATH, '/'));
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Rental-management/views/');
define('VIEW_PATH_USER_LAYOUT', $_SERVER['DOCUMENT_ROOT'] . '/Rental-management/views/user/layout/');
define('BASE_URL_NAME', '/Rental-management');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/Rental-management/Public/upload/');
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Rental-management');
