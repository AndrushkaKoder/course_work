<?php

declare(strict_types=1);

namespace App\Enums\Car;

enum CarType: int
{
    case NEW = 1;
    case USED = 2;

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getLabels(): array
    {
        return [
            self::NEW->value => 'Новый',
            self::USED->value => 'Б/У'

        ];
    }

}
