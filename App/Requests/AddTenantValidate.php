<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-11-03
 * Purpose: Validate add tenant
 */

namespace App\Requests;

use App\Models\User;

class AddTenantValidate {
    public static function validate($data, $created = true) {
        $error = '';
        $user = new User();

        if ($created && empty($data['username'])) {
            $error = 'Tên khách hàng không được để trống';
        }

        // kiểm tra số điện thoại
        else if ($created && empty($data['phone'])) {
            $error = 'Số điện thoại không được để trống';
        }

        // kiểm tra email
        else if ($created && empty($data['email'])) {
            $error = 'Email không được để trống';
        }

        // Kiểm tra email đúng dạng
        else if ($created && !preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $data['email'])) {
            $error = 'Email không hợp lệ. Ví dụ: example@gmail.com';
        }

        // Kiểm tra tồn tại email
        else if ($created && $data['is_create'] == 1 && $user->getUserByEmail($data['email'])) {
            $error = "email đã tồn tại";
        }

        // Kiểm tra hợp lệ username
        else if ($created && !preg_match('/^[a-zA-ZÀ-Ỵà-ỵ\s]+$/u', $data['username'])) {
            $error = 'Tên người dùng không đúng định dạng';
        }

        // kiểm tra hợp lệ số điện thoại
        else if ($created && !preg_match('/^0[1-9][0-9]{8}$/', $data['phone'])) {
            $error = 'Số điện thoại không hợp lệ';
        }

        // Kiểm tra ngày vào ở
        else if (empty($data['join_date'])) {
            $error = 'Ngày vào ở không được để trống';
        }

        // Kiểm tra cccd
        else if (empty($data['citizen_id'])) {
            $error = 'Căn cước công dân không được để trống';
        }

        // Kiểm tra tồn tại cccd
        else if ($created && $user->getUserByCitizenId($data['citizen_id'])) {
            $error = "Căn cước công dân đã tồn tại";
        }

        // Kiểm tra định dạng cccd
        else if (!preg_match('/^[0-9]{12}$/', $data['citizen_id'])) {
            $error = 'Căn cước công dân không đúng định dạng. Ví dụ: 012345678901';
        }

        return $error;
    }
}
