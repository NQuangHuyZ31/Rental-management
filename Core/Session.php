<?php

/*
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: provide session functionality
*/

namespace Core;

class Session
{
    // Khởi tạo session
    public static function start()
    {
        // Không khởi tạo session trong CLI mode
        if (php_sapi_name() === 'cli') {
            return;
        }
        
        if (session_status() == PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0, // session cookie (xóa khi đóng trình duyệt)
                'path' => '/',
                'domain' => 'hosty.shoplands.store', // Để trống là mặc định theo domain hiện tại
                'secure' => isset($_SERVER['HTTPS']), // Gửi cookie chỉ qua HTTPS nếu có
                'httponly' => true, // Ngăn JS truy cập
                'samesite' => 'Lax' // Hoặc 'Lax' nếu cần chia sẻ giữa subdomain
            ]);

            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
            ini_set('session.gc_maxlifetime', 3600); // 1 giờ
            session_start();
        }
    }

    // Lưu dữ liệu vào session
    public static function set($key, $value)
    {
        // Không làm gì trong CLI mode
        if (php_sapi_name() === 'cli') {
            return;
        }
        self::start();
        $_SESSION[$key] = $value;
    }

    // Lấy dữ liệu từ session
    public static function get($key)
    {
        // Trả về null trong CLI mode
        if (php_sapi_name() === 'cli') {
            return null;
        }
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Kiểm tra sự tồn tại của session
    public static function has($key)
    {
        // Trả về false trong CLI mode
        if (php_sapi_name() === 'cli') {
            return false;
        }
        self::start();
        return isset($_SESSION[$key]);
    }

    // Xóa dữ liệu khỏi session
    public static function delete($key)
    {
        // Không làm gì trong CLI mode
        if (php_sapi_name() === 'cli') {
            return;
        }
        self::start();
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    // Hủy toàn bộ session
    public static function destroy()
    {
        // Không làm gì trong CLI mode
        if (php_sapi_name() === 'cli') {
            return;
        }
        self::start();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }

    public static function debug()
    {
        // Không làm gì trong CLI mode
        if (php_sapi_name() === 'cli') {
            echo "Session debug not available in CLI mode\n";
            return;
        }
        self::start();
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }
}
