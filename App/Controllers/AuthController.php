<?php
namespace App\Controllers;

use App\Models\User;
use Core\ViewRender;

class AuthController extends Controller {
    protected $user;

    public function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    public function login() {

        $user = $this->user->getAllUsers();

        ViewRender::render('login',
            [
                'users' => $user
            ]);
    }
}