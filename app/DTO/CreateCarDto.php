<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class CreateCarDto
{
    public function __construct(public array $data, public int|string $price)
    {
    }
}
