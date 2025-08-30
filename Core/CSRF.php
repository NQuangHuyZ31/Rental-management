<?php

namespace Core;

use Core\Session;
use Core\Response;

class CSRF
{
    // Tên field CSRF token trong form
    const TOKEN_FIELD = 'csrf_token';
    
    // Tên header CSRF token
    const TOKEN_HEADER = 'X-CSRF-TOKEN';
    
    // Thời gian hết hạn token (giây)
    const TOKEN_EXPIRY = 3600; // 1 giờ
    
    /**
     * Hàm tạo CSRF token và lưu vào session
     */
    public static function generateToken()
    {
        $token = bin2hex(random_bytes(32)); // Tạo token ngẫu nhiên 64 ký tự
        
        Session::set('csrf_token', $token);
        Session::set('csrf_token_created', time());
        
        return $token;
    }
    
    /**
     * Hàm kiểm tra CSRF token
     */
    public static function verifyToken($token)
    {
        $storedToken = Session::get('csrf_token');
        $tokenCreated = Session::get('csrf_token_created');
        
        // Kiểm tra token có tồn tại không
        if (!$storedToken || !$tokenCreated) {
            return false;
        }
        
        // Kiểm tra token có hết hạn không
        if (time() - $tokenCreated > self::TOKEN_EXPIRY) {
            self::destroyToken();
            return false;
        }
        
        // Kiểm tra token có khớp không
        return hash_equals($storedToken, $token);
    }
    
    /**
     * Hàm xóa CSRF token khỏi session
     */
    public static function destroyToken()
    {
        Session::delete('csrf_token');
        Session::delete('csrf_token_created');
    }
    
    /**
     * Hàm refresh CSRF token
     */
    public static function refreshToken()
    {
        self::destroyToken();
        return self::generateToken();
    }
    
    /**
     * Hàm lấy CSRF token hiện tại
     */
    public static function getToken()
    {
        $token = Session::get('csrf_token');
        
        if (!$token) {
            $token = self::generateToken();
        }
        
        return $token;
    }
    
    /**
     * Hàm tạo HTML input field cho CSRF token
     */
    public static function getTokenField()
    {
        $token = self::getToken();
        return '<input type="hidden" name="' . self::TOKEN_FIELD . '" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
    
    /**
     * Hàm tạo meta tag cho CSRF token (dùng cho AJAX)
     */
    public static function getTokenMeta()
    {
        $token = self::getToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
    
    /**
     * Hàm lấy CSRF token từ request
     */
    private static function getTokenFromRequest()
    {
        // Kiểm tra trong POST data
        if (isset($_POST[self::TOKEN_FIELD])) {
            return $_POST[self::TOKEN_FIELD];
        }
        
        // Kiểm tra trong header
        $headers = getallheaders();
        if (isset($headers[self::TOKEN_HEADER])) {
            return $headers[self::TOKEN_HEADER];
        }
        
        // Kiểm tra trong header với tên khác (một số server không hỗ trợ getallheaders)
        if (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            return $_SERVER['HTTP_X_CSRF_TOKEN'];
        }
        
        // Kiểm tra trong query string (không khuyến khích nhưng có thể cần)
        if (isset($_GET[self::TOKEN_FIELD])) {
            return $_GET[self::TOKEN_FIELD];
        }
        
        return null;
    }
    
    /**
     * Hàm kiểm tra CSRF và trả về boolean
     * 
     * Method này sẽ:
     * - Trả về true cho non-POST requests (không cần CSRF protection)
     * - Trả về true nếu CSRF validation passed
     * - Trả về false nếu CSRF validation failed
     * 
     * Sử dụng khi bạn muốn kiểm soát flow của ứng dụng
     */
    public static function validatePostRequest()
    {
        // Chỉ kiểm tra với method POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false; // Non-POST requests không cần CSRF protection
        }
        
        try {
            // Lấy token từ các nguồn khác nhau
            $token = self::getTokenFromRequest();
            
            if (!$token) {
                return false; // Không có token
            }
            
            if (!self::verifyToken($token)) {
                return false; // Token không hợp lệ
            }
            
            // Token hợp lệ, refresh token mới
            self::refreshToken();
            
            return true; // CSRF validation passed
        } catch (\Exception $e) {
            error_log("CSRF validation error: " . $e->getMessage());
            return false;
        }
    }
  
    /**
     * Hàm xóa tất cả CSRF tokens (dùng khi logout)
     */
    public static function clearAllTokens()
    {
        self::destroyToken();
        Session::delete('csrf_token');
        Session::delete('csrf_token_created');
    }
    
    /**
     * Hàm escape HTML output
     */
    public static function e($string)
    {
        echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
