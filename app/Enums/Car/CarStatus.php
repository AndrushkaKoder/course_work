<?php

declare(strict_types=1);

namespace App\Enums\Car;

enum CarStatus: int
{
    case IN_STOCK = 1;
    case SOLD = 2;
    case RESERVED = 3;

    public function translateStatus(): string
    {
        return match ($this) {
            self::IN_STOCK => 'В наличии',
            self::SOLD => 'Продан',
            self::RESERVED => 'Резерв'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
