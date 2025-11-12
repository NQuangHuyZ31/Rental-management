<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-09-18
 * Purpose: Validate File
 */

namespace App\Requests;

class FileValidate {
    public static function validate($file , $empty = true) {
        $error = '';
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        // Trường hợp nhiều file
        if (is_array($file['name'])) {
            foreach ($file['name'] as $key => $name) {
                if ($file['error'][$key] != 0 && $empty) {
                    return 'Ảnh không được để trống hoặc tải lên lỗi';
                } elseif ($file['size'][$key] > 10 * 1024 * 1024) {
                    return 'Ảnh không được vượt quá 10MB';
                } elseif (!in_array($file['type'][$key], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])) {
                    return 'Ảnh không đúng định dạng (chỉ chấp nhận JPG, PNG, WEBP)';
                }else {
                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    if (!in_array($ext, $allowedExtensions)) {
                        return 'Định dạng ảnh không được phép';
                    }
                }
            }
        } else {
            // Trường hợp 1 file
            if ($file['error'] != 0 && $empty) {
                return 'Ảnh không được để trống hoặc tải lên lỗi';
            } elseif ($file['size'] > 10 * 1024 * 1024) {
                return 'Ảnh không được vượt quá 10MB';
            } elseif (!in_array($file['type'], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])) {
                return 'Ảnh không đúng định dạng (chỉ chấp nhận JPG, PNG, WEBP)';
            } else {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExtensions)) {
                    return 'Định dạng ảnh không được phép';
                }
            }
        }

        return '';
    }
}