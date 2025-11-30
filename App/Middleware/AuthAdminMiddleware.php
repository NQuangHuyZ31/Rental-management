<?php

/*

    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Check if the user is an admin
*/

namespace App\Middleware;

use Core\CSRF;
use Core\Middleware;
use Core\Session;
use Core\Request;
use Core\Response;

class AuthAdminMiddleware implements Middleware
{
  protected $request;

  public function __construct()
  {
    $this->request = new Request();
  }

  public function handle($request, $next)
  {

    if (!Session::has('user') || (Session::has('user') && Session::get('user')['role'] != '1')) {
			if ($this->isApiRequest($request)) {
				Response::json(['status' => 'error', 'msg' => 'Vui lòng đăng nhập', 'token' => CSRF::getTokenRefresh()], 401);
				exit();
			}
			header('location: ' . BASE_URL . '/login');
			exit();
		}

		if (Session::has('user') && Session::get('user')['role'] != '1') {
			header('location: ' . Session::get('current_url'));
			exit();
		}
    return $next($request);
  }

  public function isApiRequest($request)
  {
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    return stripos($accept, 'application/json') !== false;
  }
}
