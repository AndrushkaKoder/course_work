<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        if (Option::query()->count() > 0) {
            $this->command->error('Options table already exists.');

            return;
        }

        foreach ($this->getOptions() as $option) {
            Option::query()->create($option);
        }

        $this->command->info('Options table has been created.');
    }

    private function getOptions(): array
    {
        return [
            [
                'title' => 'Коврики',
                'price' => 15000,
                'count' => 50,
                'preview' => '',
            ],
            [
                'title' => 'Бронирование фар',
                'price' => 30000,
                'count' => 50,
                'preview' => '',
            ],
            [
                'title' => 'Тонировка',
                'price' => 9000,
                'count' => 50,
                'preview' => '',
            ],
            [
                'title' => 'Керамика кузова',
                'price' => 100000,
                'count' => 50,
                'preview' => '',
            ],
        ];
    }
}
