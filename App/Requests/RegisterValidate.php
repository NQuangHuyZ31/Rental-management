<?php

/*
* Author: Huy Nguyen
* Date: 2025-09-01
* Purpose: Validate Register
*/

namespace App\Requests;

use App\Models\User;

class RegisterValidate
{

  public static function validate($data)
  {

    $user = new User();

    $error = '';

    // Kiểm tra username
    if (empty($data['username']) || empty($data['email']) || empty($data['role']) || empty($data['phone']) || empty($data['password']) || empty($data['confirm_password'])) {

      $error = 'Không được để trống';
    }

    // Kiểm tra hợp lệ username
    else if (!preg_match('/^[a-zA-ZÀ-Ỵà-ỵ\s]+$/u', $data['username'])) {
      $error = 'Tên người dùng không đúng định dạng. Ví dụ: Nguyễn Văn A';
    }

    // Kiểm tra email đúng dạng
    else if (!preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $data['email'])) {
      $error = 'Email không hợp lệ. Ví dụ: example@gmail.com';
    }

    // Kiểm tra tồn tại email
    else if ($user->getUserByEmail($data['email'])) {
      $error = "email đã tồn tại";
    }

    // kiểm tra  số điện thoại đúng dạng
    else if (!preg_match('/^0[1-9][0-9]{8}$/', $data['phone'])) {
      $error = 'Số điện thoại không hợp lệ. Ví dụ: 0909090909';
    }

    // Kiểm tra tồn tại số điện thoại
    else if ($user->getUserByPhone($data['phone'])) {
      $error = "Số điện thoại đã tồn tại";
    }

    // Kiểm tra độ dài mật khẩu
    else if (strlen($data['password']) < 6) {
      $error = 'Mật khẩu phải có ít nhất 6 kí tự';
    }

    // Kiểm tra password đúng định dạng
    else if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/', $data['password'])) {
      $error = 'Mật khẩu không đúng định dạng. Ví dụ: Abc@123';
    }

    // Kiểm tra password và confirm password có trùng khớp không
    else if (!empty($data['password']) && !empty($data['confirm_password']) && $data['password'] !== $data['confirm_password']) {
      $error = 'Password không trùng khớp';
    }

    return $error;
  }
}
