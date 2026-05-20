<?php

declare(strict_types=1);

namespace App\Enums\Sail;

enum SailType: int
{
    case BUY = 1;
    case SELL = 2;

    public static function values(): array
    {
        return [
            self::BUY->value => 'Покупка',
            self::SELL->value => 'Продажа',
        ];
    }

    public static function toFormValue(mixed $type, self $default): int
    {
        if ($type instanceof self) {
            return $type->value;
        }

        if ($type === null || $type === '') {
            return $default->value;
        }

        return (int) $type;
    }
}
