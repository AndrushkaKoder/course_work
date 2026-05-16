<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateCarDto;
use App\Enums\Sail\SailType;
use App\Models\Car;
use App\Models\Sail;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function __construct(private CarService $carService)
    {
    }

    /**
     * @param Sail|null $sail
     * @param array $data
     * @return Sail
     * @throws Throwable
     */
    public function updateOrCreate(?Sail $sail, array $data): Sail
    {
        return $sail->exists ? $this->update($sail, $data) : $this->create($data);
    }

    private function update(Sail $sail, array $data): Sail
    {
        $attributes = array_intersect_key($data, array_flip(self::ATTRIBUTE_KEYS));

        if (array_key_exists('files', $data)) {
            $attributes['files'] = $this->normalizeStoredFiles($data['files']);
        }

        if ($attributes !== []) {
            $sail->update($attributes);
        }

        return $sail->refresh();
    }

    /**
     * @param array $data
     * @return Sail
     * @throws Throwable
     */
    private function create(array $data): Sail
    {
        return DB::transaction(function () use ($data) {
            return match (SailType::tryFrom((int)$data['type'])) {
                SailType::BUY => $this->createBuySail($data),
                SailType::SELL => $this->createSellSail($data),
                default => throw new Exception('Незивестный тип сделки')
            };
        });
    }

    private function createSellSail(array $data): Sail
    {
        return $this->createSail($data);
    }

    private function createBuySail(array $data): Sail
    {
        $car = $this->carService->createNewCar(
            new CreateCarDto(data: $data['car'], price: $data['price'])
        );

        return $this->createSail($data, $car);
    }

    private function createSail(array $data, ?Car $car = null): Sail
    {
        $sail = new Sail();
        $sail->status = $data['status'];
        $sail->car_id = $data['car_id'] ?? $car->id;
        $sail->client_id = $data['client_id'];
        $sail->user_id = Auth::id();
        $sail->type = $data['type'];
        $sail->price = $data['price'];
        $sail->files = array_key_exists('files', $data)
            ? $this->normalizeStoredFiles($data['files'])
            : null;
        $sail->save();

        return $sail;
    }

    /**
     * @return list<string>|null
     */
    private function normalizeStoredFiles(mixed $files): ?array
    {
        if ($files === null || $files === '' || $files === []) {
            return null;
        }

        $items = is_array($files) ? $files : [$files];
        $paths = [];

        foreach ($items as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $paths[] = $file->store('', 'public');
            } elseif (is_string($file) && $file !== '') {
                $paths[] = $file;
            }
        }

        return $paths === [] ? null : $paths;
    }
}
