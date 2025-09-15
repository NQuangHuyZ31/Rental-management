<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-14
 * Purpose: Validate Update Profile
 */

namespace App\Requests;

class UpdateProfileValidate {

	public static function validate($data) {
		$error = '';

		if (empty($data['username'])) {
			$error = 'Tên người dùng không được trống';
		}

		else if (empty($data['phone'])) {
			$error = 'Số điện thoại không được trống';
		}

		else if (!preg_match('/^[a-zA-ZÀ-Ỵà-ỵ\s]+$/u', $data['username'])) {
			$error = 'Tên người dùng không đúng định dạng';
		}

		else if (!preg_match('/^0[1-9][0-9]{8}$/', $data['phone'])) {
			$error = 'Số điện thoại không hợp lệ';
		}

		return $error;
	}
}