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

        if (empty($data['customer_name']) || empty($data['customer_email']) || empty($data['customer_phone']) || empty($data['support_type']) || empty($data['description_problem'])) {
            $error = 'Thông tin không được trống';
        }

        // Kiểm tra email đúng dạng
        else if (!preg_match('/^[\w\.-]+@[\w\.-]+\.com$/', $data['customer_email'])) {
            $error = 'Email không hợp lệ. Ví dụ: example@gmail.com';
        }

        // Kiểm tra số điện thoại đúng định dạng (chỉ chứa chữ số và có độ dài từ 10-15 ký tự)
        else if (!preg_match('/^[0-9]{10,15}$/', $data['customer_phone'])) {
            $error = 'Số điện thoại không hợp lệ.';
        }
        
        return $error;
    }
}
