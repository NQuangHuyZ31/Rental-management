<?php
namespace App\Controllers;

class AuthController extends Controller
{
  public function login()
  {
    return view('auth.login');
  }
}