<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-10-22
 * Purpose: Validate support customer form
 */

namespace App\Requests;

class SupportCustomerValidate {
    public static function validate($data) {
        $error = '';

        if (empty($data['customer_name']) || empty($data['customer_email']) || empty($data['support_type']) || empty($data['description_problem'])) {
            $error = 'Thông tin không được trống';
        }

        // Kiểm tra email đúng dạng
        else if (!preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $data['customer_email'])) {
            $error = 'Email không hợp lệ. Ví dụ: example@gmail.com';
        }
        return $error;
    }
}
