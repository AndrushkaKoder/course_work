<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateCarDto;
use App\DTO\GetCarsDto;
use App\Enums\Car\CarStatus;
use App\Enums\Car\CarType;
use App\Models\Car;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class CarService
{
    private const string CARS_CACHE_KEY = 'cars:list';

    public function createNewCar(CreateCarDto $dto): Car
    {
        $car = new Car;

        $data = $dto->data;

        $car->status = CarStatus::IN_STOCK;
        $car->mark = $data['mark'];
        $car->model = $data['model'];
        $car->color = $data['color'];
        $car->price = $dto->price;
        $car->type = $data['type'];
        $car->year = $data['year'];
        $car->mileage = $data['mileage'];
        $car->vin_code = $data['vin_code'];

        $car->addPreview($data['preview']);
        $car->addMultiple($data['files']);

        $car->save();

        $this->forgetCarsCache();

        return $car;
    }

    public function updateCarStatus(int $carId, CarStatus $status): void
    {
        Car::query()
            ->whereKey($carId)
            ->update(['status' => $status]);

        $this->forgetCarsCache();
    }

    public function getAllCars(): GetCarsDto
    {
        /** @var list<array<string, mixed>> $rows */
        $rows = Cache::remember(self::CARS_CACHE_KEY, 3600 * 24, function (): array {
            return Car::query()
                ->inStock()
                ->orderByDesc('created_at')
                ->get()
                ->map(fn (Car $car): array => $car->attributesToArray())
                ->all();
        });

        $cars = Car::hydrate($rows);

        /** @var Collection<int, Car> $newCars */
        $newCars = $cars->filter(fn (Car $car): bool => $car->type === CarType::NEW)->values();

        /** @var Collection<int, Car> $usedCars */
        $usedCars = $cars->filter(fn (Car $car): bool => $car->type === CarType::USED)->values();

        return new GetCarsDto(
            allCars: $cars,
            newCars: $newCars,
            usedCars: $usedCars,
        );
    }

    public function forgetCarsCache(): void
    {
        Cache::forget(self::CARS_CACHE_KEY);
    }
}
