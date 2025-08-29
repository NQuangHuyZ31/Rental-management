<?php
define('BASE_PATH', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE_PATH, '/'));
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/KLTN-HD/views/');
define('VIEW_PATH_USER_LAYOUT', $_SERVER['DOCUMENT_ROOT'] . '/KLTN-HD/views/user/layout/');
define('BASE_URL_NAME', '/KLTN-HD');
// database
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASS", '');
define("DB_NAME", 'rental_db');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/KLTN-HD/Public/upload/');
