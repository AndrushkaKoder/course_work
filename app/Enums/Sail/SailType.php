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
}
