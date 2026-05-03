<?php

namespace App\MoonShine\Resources\Car;

use App\Enums\Car\CarType;
use App\Models\Car;
use App\MoonShine\Resources\Car\Pages\CarFormPage;
use App\MoonShine\Resources\Car\Pages\CarIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

class AbstractCarResource extends ModelResource
{
    protected string $model = Car::class;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CarIndexPage::class,
            CarFormPage::class
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'model',
            'mark',
            'year',
            'color',
            'vin_code',
            'state_number'
        ];
    }
}
