<?php

namespace App\Support;

/**
 * ابزارهای کمکی اعداد فارسی
 */
class Fa
{
    /**
     * تبدیل ارقام لاتین به ارقام فارسی
     */
    public static function num(int|float|string|null $value): string
    {
        return strtr((string) $value, [
            '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
            '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹',
        ]);
    }
}
