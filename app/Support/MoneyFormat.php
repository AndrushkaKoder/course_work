<?php

declare(strict_types=1);

namespace App\Support;

final class MoneyFormat
{
    public static function format(int|float|string|null $amount, string $suffix = 'P'): string
    {
        $value = is_numeric($amount) ? (int) $amount : 0;
        $formatted = number_format($value, 0, ',', ' ');

        if ($suffix === '') {
            return $formatted;
        }

        return $formatted.' '.$suffix;
    }
}
