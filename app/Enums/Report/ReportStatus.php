<?php

declare(strict_types=1);

namespace App\Enums\Report;

enum ReportStatus: int
{
    case PENDING = 0;
    case PROCESSING = 1;
    case COMPLETED = 2;
    case FAILED = 3;

    public function formattedValue(): string
    {
        return match ($this) {
            self::PENDING => 'В очереди',
            self::PROCESSING => 'Формируется',
            self::COMPLETED => 'Готов',
            self::FAILED => 'Ошибка',
        };
    }
}
