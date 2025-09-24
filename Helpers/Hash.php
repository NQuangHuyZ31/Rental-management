<?php

/*
Author: Huy Nguyen
Date: 2025-08-29
Purpose: provide hash functionality
 */

namespace Helpers;

class Hash {
    private static function getKey() {
        return $_ENV['VERIFY_ACCOUNT_KEY'];
    }

    public static function encrypt($value) {
        $key = openssl_digest(self::getKey(), 'SHA256', TRUE);
        $cipher = "AES-128-CBC";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        // binary cipher
        $ciphertext_raw = openssl_encrypt($value, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        // or increase security with hashed cipher; (hex or base64 printable eg. for transmission over internet)
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }

    public static function decrypt($value) {
        $cipher = "AES-128-CBC";

        $c = base64_decode($value);

        $key = openssl_digest(self::getKey(), 'SHA256', TRUE);

        $ivlen = openssl_cipher_iv_length($cipher);

        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }

    }

    public static function verify($inputOtp, $hashedOtp) {
        // Chuyển đổi thành string
        $inputOtp = (string) $inputOtp;
        // Giải mã OTP đã được mã hóa lưu trong DB
        $decryptedOtp = self::decrypt($hashedOtp);
        // Chuyển đổi thành string
        $decryptedOtp = (string) $decryptedOtp;

        // So sánh với OTP người dùng nhập
        return $decryptedOtp && $decryptedOtp == $inputOtp ? true : false;
    }
}
