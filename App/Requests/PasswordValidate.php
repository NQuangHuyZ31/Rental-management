<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-23
* Purpose: Validate Password
*/

namespace App\Requests;

class PasswordValidate
{
	public static function validate($data)
	{
		$error = '';

		if (empty($data['password']) || empty($data['confirm_password'])) {
			$error = 'Mật khẩu không được để trống';
		}

		else if (strlen($data['password']) < 6) {
			$error = 'Mật khẩu phải có ít nhất 6 kí tự';
		}

		else if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/', $data['password'])) {
			$error = 'Mật khẩu không đúng định dạng. Ví dụ: Abc@123';
		}

		else if (!empty($data['confirm_password']) && $data['password'] !== $data['confirm_password']) {
			$error = 'Mật khẩu không trùng khớp';
		}

		return $error;
	}
}