<?php

declare(strict_types=1);

namespace App\Support;

final class CreditApplicationCancelReasons
{
    public const array REASONS = [
        'Недостаточный уровень дохода для одобрения кредита',
        'Негативная кредитная история',
        'Превышен допустимый размер кредитной нагрузки',
        'Несоответствие предоставленных документов требованиям банка',
        'Отказ по внутренней скоринговой модели банка',
        'Наличие просроченной задолженности у заёмщика',
        'Недостаточный стаж работы на текущем месте',
    ];

    public static function random(): string
    {
        return self::REASONS[array_rand(self::REASONS)];
    }
}
