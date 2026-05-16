<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateCarDto;
use App\Models\Car;

final class CarService
{
    public function createNewCar(CreateCarDto $dto): Car
    {
        $car = new Car();

        $data = $dto->data;
        $price = $dto->price;

        $car->count = 1;
        $car->mark = $data['mark'];
        $car->model = $data['model'];
        $car->color = $data['color'];
        $car->price = $price;
        $car->type = $data['type'];
        $car->year = $data['year'];
        $car->mileage = $data['mileage'];
        $car->vin_code = $data['vin_code'];

        $car->addPreview($data['preview']);
        $car->addMultiple($data['files']);

        $car->save();

        return $car;
    }
}
