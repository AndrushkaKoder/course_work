<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        if (Client::query()->count() > 0) {
            $this->command->error('Clients table already exists.');

            return;
        }

        foreach ($this->getClients() as $client) {
            Client::create($client);
        }

        $this->command->info('clients table has been created.');
    }

    private function getClients(): array
    {
        return [
            [
                'name' => 'Иван Иванов',
                'phone' => '+7 (962) 555 44 33',
                'passport_series' => 1234,
                'passport_number' => 123456,
            ],
            [
                'name' => 'Семен Семенов',
                'phone' => '+7 (953) 333 22 11',
                'passport_series' => 4567,
                'passport_number' => 657890,
            ],
            [
                'name' => 'Андрей Андреев',
                'phone' => '+7 (962) 553 44 21',
                'passport_series' => 0001,
                'passport_number' => 123458,
            ],
            [
                'name' => 'Михаил Михайлов',
                'phone' => '+7 (910) 021 44 33',
                'passport_series' => 9943,
                'passport_number' => 234466,
            ],
        ];
    }
}
