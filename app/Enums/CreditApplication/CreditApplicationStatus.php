<?php

declare(strict_types=1);

namespace App\Enums\CreditApplication;

enum CreditApplicationStatus: int
{
    case SUCCESS = 0;
    case FAILED = 1;

    public static function getValues(): array
    {
        return [
            self::SUCCESS->value => 'Одобрено',
            self::FAILED->value => 'Отказ',
        ];
    }

    public function formattedValue(): string
    {
        return match ($this) {
            self::SUCCESS => 'Одобрено',
            self::FAILED => 'Отказ',
        };
    }

    public static function randomBankResult(): self
    {
        $cases = self::cases();

        return $cases[array_rand($cases)];
    }
}
