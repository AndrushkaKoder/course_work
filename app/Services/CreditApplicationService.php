<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\ProcessCreditApplicationJob;
use App\Models\Client;
use App\Models\CreditApplication;
use Illuminate\Support\Facades\DB;
use MoonShine\Laravel\MoonShineAuth;
use Throwable;

final readonly class CreditApplicationService
{
    private const array ATTRIBUTE_KEYS = [
        'client_id',
        'sum',
    ];

    /**
     * @throws Throwable
     */
    public function updateOrCreate(?CreditApplication $application, array $data): CreditApplication
    {
        return $application?->exists
            ? $this->update($application, $data)
            : $this->create($data);
    }

    /**
     * @throws Throwable
     */
    private function create(array $data): CreditApplication
    {
        return DB::transaction(function () use ($data) {
            $this->syncClientPassport($data);

            $application = $this->saveApplication(new CreditApplication, $data);

            ProcessCreditApplicationJob::dispatch($application);

            return $application;
        });
    }

    private function update(CreditApplication $application, array $data): CreditApplication
    {
        $this->syncClientPassport($data);

        return $this->saveApplication($application, $data);
    }

    private function syncClientPassport(array $data): void
    {
        if (! isset($data['client_id'])) {
            return;
        }

        $client = Client::findOrFail($data['client_id']);
        $updates = [];

        if (empty($client->passport_series) && ! empty($data['passport_series'])) {
            $updates['passport_series'] = $data['passport_series'];
        }

        if (empty($client->passport_number) && ! empty($data['passport_number'])) {
            $updates['passport_number'] = $data['passport_number'];
        }

        if ($updates !== []) {
            $client->update($updates);
        }
    }

    private function saveApplication(CreditApplication $application, array $data): CreditApplication
    {
        $attributes = array_intersect_key($data, array_flip(self::ATTRIBUTE_KEYS));

        foreach ($attributes as $key => $value) {
            $application->{$key} = $value;
        }

        if (isset($data['files'])) {
            $application->addMultiple($data['files']);
        }

        if (! $application->exists) {
            $application->user_id = MoonShineAuth::getGuard()->id();
        }

        $application->save();

        return $application->refresh();
    }
}
