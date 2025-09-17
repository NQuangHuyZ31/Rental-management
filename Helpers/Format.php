<?php

namespace Helpers;

class Format {
    public static function forMatPrice($price) {
        return number_format($price, 0, '.', '.');
    }

    public static function formatNumber($number) {
        return number_format($number, 0);
    }

    // added by Huy Nguyen format unit
    public static function formatUnit($number) {
        if ($number < 0) {
            return;
        }

        if ($number > 1000000) {
            return number_format($number / 1000000, 2) . 'M';
        } else {
            return number_format($number / 1000, 2) . 'K';
        };
    }
}
