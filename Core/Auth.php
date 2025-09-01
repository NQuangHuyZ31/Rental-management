<?php
/*
    Author: Huy Nguyen
    Date: 2025-08-25
    Purpose: provide auth functionality
*/

namespace Core;

use Core\Database;
use Core\Session;

class Auth
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();

        // Bắt đầu phiên làm việc nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Đăng nhập người dùng
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login($email, $password, $role = '1')
    {
        // Truy vấn người dùng theo email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND account_status = 'active' AND deleted = 0 AND role_id = ?");
        $stmt->execute([$email, $role]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Kiểm tra người dùng và xác minh mật khẩu
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true); // chống session fixation
            Session::set('user', [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role_id'],
                'session_id' => session_id(),
            ]);
            return true;
        }

        return false;
    }

    // public function loginWithoutPassword($email)
    // {
    //     // Truy vấn người dùng theo email
    //     $stmt = $this->db->prepare("select * from users where email = ? and status = 'active'");
    //     $stmt->execute([$email]);
    //     $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    //     // Kiểm tra người dùng và xác minh mật khẩu
    //     if ($user) {

    //         Session::set('user', [
    //             'id' => $user['id'],
    //             'username' => $user['username'],
    //             'email' => $user['email'],
    //             'role' => $user['role_id'],
    //         ]);
    //         return $user;
    //         // if ($user['role'] === 'customer') {
    //         // return $user;
    //         // }
    //         // Lưu thông tin người dùng vào session
    //     }

    //     return false;
    // }

    /**
     * Kiểm tra người dùng đã đăng nhập
     *
     * @return bool
     */
    public function check()
    {
        return isset($_SESSION['user']);
    }

    /**
     * Lấy thông tin người dùng hiện tại
     *
     * @return array|null
     */
    public function user()
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Đăng xuất người dùng
     */
    public function logout()
    {
        // Xóa tất cả session
        $_SESSION = [];

        // Hủy session trên server
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        session_destroy();
    }


    /**
     * Kiểm tra quyền của người dùng
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === $role;
    }
}
