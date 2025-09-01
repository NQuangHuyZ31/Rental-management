<?php

/*
* Author: Huy Nguyen
* Date: 2025-09-01
* Purpose: Validate OTP
*/

namespace App\Requests;

class VerifyOtpValidate
{
  public static function validate($data)
  {
    $errors = '';

    if ($data == '') {
      $errors = 'Mã OTP không được để trống.';
    }

    // Kiểm tra độ dài mã OTP
    elseif (strlen($data) !== 6) {
      $errors = 'Mã OTP phải có đủ 6 chữ số.';
    }

    // Kiểm tra otp code có phải là số
    elseif (!is_numeric($data)) {
      $errors = 'Mã OTP phải là số.';
    }

    return $errors;
  }
}
