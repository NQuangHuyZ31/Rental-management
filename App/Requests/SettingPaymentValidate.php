<?php
/*

* Author: Huy Nguyen
* Date: 2025-09-17
* Purpose: Validate Setting Payment
*/

namespace App\Requests;

class SettingPaymentValidate {
	public static function validate($data) {
		$error = '';

		if (empty($data['bank_account_name']) || empty($data['bank_code']) || empty($data['bank_account_number']) || empty($data['user_bank_name']) || empty($data['api_key'])) {
			$error = 'Thông tin không được để trống';
		}

		// validate tên chủ tài khoản
		else if (!preg_match('/^[A-Z\s]+$/', $data['user_bank_name'])) {
			$error = 'Tên chủ tài khoản không đúng định dạng. Ví dụ: NGUYEN VAN A';
		}

		// validate số tài khoản
		else if (!preg_match('/^[0-9]+$/u', $data['bank_account_number'])) {
			$error = 'Số tài khoản không đúng định dạng. Ví dụ: 00036489543';
		}

		return $error;
	}
	
}
