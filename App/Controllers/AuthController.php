<?php
namespace App\Controllers;

use App\Models\User;
use Core\ViewRender;
use App\Models\Role;
use Core\SendMail;
use Queue\SendEmailJob;

class AuthController extends Controller {
    protected $user;
    protected $role;
    protected $sendEmailJob;

    public function __construct() {
        parent::__construct();
        $this->user = new User();
        $this->role = new Role();
    }

    public function showLoginPage() {
        // SendMail::sendOTP('huynguyenharu3108@gmail.com', 'Huy Nguyen','333333', 'This is a test email');
        $this->sendEmailJob = new SendEmailJob();
        $this->sendEmailJob->dispatch([
            'to' => 'huynguyenharu3108@gmail.com',
            'subject' => 'Test Email',
            'message' => 'This is a test email'
        ]);
        ViewRender::render('login');
    }

    public function handleLogin() {}

    public function showRegisterPage() {

        $roles = $this->role->getAllRoles();
        ViewRender::render('register',
            [
                'roles' => $roles
            ]
        );
    }

    public function handleRegister() {}

    public function logout() {
        $this->auth->logout();
        header('Location: /');
        exit();
    }
}