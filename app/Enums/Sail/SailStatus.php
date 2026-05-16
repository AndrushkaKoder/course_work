<?php

declare(strict_types=1);

namespace App\Enums\Sail;

enum SailStatus: int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case CANCELLED = 2;

    public static function getValues(): array
    {
        return [
            self::PENDING->value => 'Подготовка',
            self::COMPLETED->value => 'Завершена',
            self::CANCELLED->value => 'Отменена',
        ];
    }

    public function formattedValue(): string
    {
        return match ($this->value) {
            self::PENDING->value => 'Подготовка',
            self::COMPLETED->value => 'Завершена',
            self::CANCELLED->value => 'Отменена',
        };
    }
}
