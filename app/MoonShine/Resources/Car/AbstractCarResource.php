<?php

namespace App\MoonShine\Resources\Car;

use App\DTO\CreateCarDto;
use App\Models\Car;
use App\MoonShine\Resources\Car\Pages\CarFormPage;
use App\MoonShine\Resources\Car\Pages\CarIndexPage;
use App\Services\CarService;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
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
            CarFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
        ];
    }

    public function save(DataWrapperContract $item, ?FieldsContract $fields = null): DataWrapperContract
    {
        $request = request();
        $data = $request->all();
        $service = app(CarService::class);

        if (is_null($request->input('mileage'))) {
            $data['mileage'] = 0;
        }

        $carDto = new CreateCarDto($data, request()->input('price'));
        $service->createNewCar($carDto);

        return $item;
    }
}
