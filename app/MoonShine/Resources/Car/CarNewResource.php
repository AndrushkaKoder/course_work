<?php

namespace App\MoonShine\Resources\Car;

use App\Enums\Car\CarStatus;
use App\Enums\Car\CarType;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CarNewResource extends AbstractCarResource
{
    protected string $title = 'Новые автомобили';

    public function getUriKey(): string
    {
        return 'new';
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder
            ->where('type', CarType::NEW)
            ->where('status', CarStatus::IN_STOCK);
    }
}
