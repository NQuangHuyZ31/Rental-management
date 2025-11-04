<?php

namespace App\Controllers;

use Core\Auth;
use Core\Database;

class Controller {

    protected $db;
    protected $auth;
    protected $userID;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();

        if ($this->db === null) {
            die("Lỗi: Không thể kết nối database!");
        }

        // Bắt đầu phiên làm việc nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->auth = new Auth();
        $this->userID = $this->auth->user()['id'] ?? '';
    }
}
