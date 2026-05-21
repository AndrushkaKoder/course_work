<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateCarDto;
use App\Enums\Sail\SailStatus;
use App\Enums\Sail\SailType;
use App\Models\Car;
use App\Models\Sail;
use Exception;
use Illuminate\Support\Facades\DB;
use MoonShine\Laravel\MoonShineAuth;
use Throwable;

final readonly class SailService
{
    private const array ATTRIBUTE_KEYS = [
        'client_id',
        'user_id',
        'car_id',
        'price',
        'status',
        'type',
    ];

    public function __construct(private CarService $carService) {}

    /**
     * @throws Throwable
     */
    public function updateOrCreate(?Sail $sail, array $data): Sail
    {
        $this->carService->forgetCarsCache();

        if ($sail !== null && $sail->exists) {
            return $this->update($sail, $data);
        }

        return $this->create($data);
    }

    private function update(Sail $sail, array $data): Sail
    {
        $this->writeOffCar(
            $sail,
            $this->resolveStatus($data['status'] ?? null),
        );
        $attributes = array_intersect_key($data, array_flip(self::ATTRIBUTE_KEYS));

        if ($attributes !== []) {
            $sail->update($attributes);
        }

        return $sail->refresh();
    }

    /**
     * @throws Throwable
     */
    private function create(array $data): Sail
    {
        return match (SailType::tryFrom((int) $data['type'])) {
            SailType::BUY => $this->createBuySail($data),
            SailType::SELL => $this->createSellSail($data),
            default => throw new Exception('Незивестный тип сделки')
        };
    }

    /**
     * @throws Throwable
     */
    private function createSellSail(array $data): Sail
    {
        if (! isset($data['car_id'])) {
            throw new Exception('Выберите автомобиль');
        }

        return DB::transaction(function () use ($data) {
            $sail = $this->createSail($data);

            $this->writeOffCar($sail, $this->resolveStatus($data['status'] ?? null));

            return $sail;
        });
    }

    /**
     * @throws Throwable
     */
    private function createBuySail(array $data): Sail
    {
        return DB::transaction(function () use ($data) {
            $car = $this->carService->createNewCar(
                new CreateCarDto(data: $data['car'], price: $data['price'])
            );

            return $this->createSail($data, $car);
        });
    }

    private function createSail(array $data, ?Car $car = null): Sail
    {
        $sail = new Sail;
        $sail->status = $data['status'];
        $sail->car_id = $data['car_id'] ?? $car->id;
        $sail->client_id = $data['client_id'];
        $sail->user_id = MoonShineAuth::getGuard()->id();
        $sail->type = $data['type'];
        $sail->price = $data['price'];

        if (isset($data['files'])) {
            $sail->addMultiple($data['files']);
        }

        $sail->save();

        if (isset($data['options'])) {
            $sail->options()->sync($data['options']);
        }

        return $sail;
    }

    private function writeOffCar(Sail $sail, ?SailStatus $newStatus): void
    {
        if ($newStatus === null || $newStatus === SailStatus::PENDING) {
            return;
        }

        $previousStatus = $sail->wasRecentlyCreated
            ? null
            : $this->resolveStatus($sail->getOriginal('status') ?? $sail->status);

        if ($previousStatus === $newStatus) {
            return;
        }

        if ($previousStatus === SailStatus::COMPLETED && $newStatus === SailStatus::CANCELLED) {
            $this->carService->incrementCar($sail->car_id);

            return;
        }

        if ($this->resolveType($sail->type) === SailType::SELL && $newStatus === SailStatus::COMPLETED) {
            $this->carService->decrementCar($sail->car_id);
        }
    }

    private function resolveStatus(mixed $status): ?SailStatus
    {
        if ($status instanceof SailStatus) {
            return $status;
        }

        if ($status === null || $status === '') {
            return null;
        }

        return SailStatus::tryFrom((int) $status);
    }

    private function resolveType(mixed $type): ?SailType
    {
        if ($type instanceof SailType) {
            return $type;
        }

        if ($type === null || $type === '') {
            return null;
        }

        return SailType::tryFrom((int) $type);
    }
}
