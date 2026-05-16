<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Car;

use App\Enums\Car\CarType;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CarUsedResource extends AbstractCarResource
{
    protected string $title = 'Автомобили с пробегом';

    public function getUriKey(): string
    {
        return 'used';
    }

    protected function search(): array
    {
        return [
            'id'
        ];
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder
            ->where('count', '>', 0)
            ->where('type', CarType::USED);
    }
}
