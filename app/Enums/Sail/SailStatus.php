<?php

declare(strict_types=1);

namespace App\Enums\Sail;

enum SailStatus: int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case CANCELLED = 2;
}
