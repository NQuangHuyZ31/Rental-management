<?php 

/*
	Author: Huy Nguyen
	Date: 2025-09-06
	Purpose: Validate Rental Post
*/

namespace App\Requests;

class RentalPostValidate
{
	public static function validate($data)
	{
		$error = '';
		 $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

		if (empty($data['title']) || empty($data['category'])|| empty($data['contact_name']) 
		|| empty($data['contact_phone']) || empty($data['price']) || empty($data['area']) || empty($data['electricity_price'])
		|| empty($data['water_price']) || empty($data['available_date']) || empty($data['max_occupants']) || empty($data['opening_time'])
		|| empty($data['closing_time']) || empty($data['province']) || empty($data['ward'])) {
			$error = 'Thông tin có dấu * là bắt buộc';
		}

		// validate tên người liên hệ
		else if (!preg_match('/^[a-zA-ZÀ-Ỵà-ỵ\s]+$/u', $data['contact_name'])) {
			$error = 'Tên người liên hệ không đúng định dạng. Ví dụ: Nguyễn Văn A';
		}

		// validate số điện thoại
		else if (!preg_match('/^0[1-9][0-9]{8}$/', $data['contact_phone'])) {
			$error = 'Số điện thoại không đúng định dạng. Ví dụ: 0909090909';
		}

		// validate date
		else if (date('Y-m-d', strtotime($data['available_date'])) < date('Y-m-d')) {
			$error = 'Ngày có thể vào ở không được nhỏ hơn ngày hiện tại';
		}

		// validate image 
		else if (!empty($data['images'])) { 
			foreach ($data['images'] as $image) {
				$ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
				if ($image['error'] !== UPLOAD_ERR_OK) {
					$error = 'Ảnh không được để trống';
				} else if ($image['size'] > 10 * 1024 * 1024) {
					$error = 'Ảnh không được vượt quá 10MB';
				} else if ($image['type'] !== 'image/jpeg' && $image['type'] !== 'image/png' && $image['type'] !== 'image/jpg' && $image['type'] !== 'image/webp') {
					$error = 'Ảnh không đúng định dạng';
				} else if (!in_array($ext, $allowedExtensions)) {
					$error = 'Định dạng ảnh không được phép';
				}
			}
		}

		return $error;
	}
}
