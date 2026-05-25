<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\Sail\SailType;
use Illuminate\Support\Carbon;

final readonly class CreateReportDto
{
    public function __construct(
        public Carbon $from,
        public Carbon $to,
        public SailType $type,
    ) {}
}
