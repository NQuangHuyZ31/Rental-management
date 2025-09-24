<?php

/*
* Author: Huy Nguyen
* Date: 2025-09-18
* Purpose: Validate File
*/

namespace App\Requests;

class FileValidate
{
	public static function validate($file) {
		$error = '';
		if ($file['error'] != 0 ) {
			$error = 'Ảnh không được để trống';
		} else if ($file['size'] > 10 * 1024 * 1024) {
			$error = 'Ảnh không được vượt quá 10MB';
		} else if ($file['type'] !== 'image/jpeg' && $file['type'] !== 'image/png' && $file['type'] !== 'image/jpg' && $file['type'] !== 'image/webp') {
			$error = 'Ảnh không đúng định dạng';
		}
	}
}