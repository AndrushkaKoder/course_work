<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

final class GetCarsDto
{
    public EloquentCollection $allCars {
        get => $this->allCars;
    }

    public SupportCollection $newCars {
        get => $this->newCars;
    }

    public SupportCollection $usedCars {
        get => $this->usedCars;
    }

    public function __construct(EloquentCollection $allCars, SupportCollection $newCars, SupportCollection $usedCars)
    {
        $this->allCars = $allCars;
        $this->newCars = $newCars;
        $this->usedCars = $usedCars;

    }
}
