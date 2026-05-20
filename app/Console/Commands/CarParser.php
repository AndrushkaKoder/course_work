<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Car\CarType;
use App\Models\Car;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

#[Signature('car:parser')]
#[Description('Command description')]
class CarParser extends Command
{
    /**
     * @throws ConnectionException
     */
    public function handle(): void
    {
        if (Car::count()) {
            $this->error('Список машин уже заполнен');

            return;
        }

        $this->parseUsed();
    }

    /**
     * @throws ConnectionException|Exception
     */
    private function parseUsed(): void
    {
        $response = Http::get(
            'https://apiweb.rolf.ru/api/v2/vehicles/new/other-listing?type=car&sort=id:asc&city_id=1&count=-12&exclude_vehicle_id%5B0%5D=327344&exclude_vehicle_id%5B1%5D=338040&exclude_vehicle_id%5B2%5D=354764&exclude_vehicle_id%5B3%5D=356331&exclude_vehicle_id%5B4%5D=357147&exclude_vehicle_id%5B5%5D=357188&exclude_vehicle_id%5B6%5D=357541&exclude_vehicle_id%5B7%5D=359054&exclude_vehicle_id%5B8%5D=359129&exclude_vehicle_id%5B9%5D=359249&exclude_vehicle_id%5B10%5D=359423&exclude_vehicle_id%5B11%5D=360464&exclude_vehicle_id%5B12%5D=360510&exclude_vehicle_id%5B13%5D=361275&exclude_vehicle_id%5B14%5D=361599&exclude_vehicle_id%5B15%5D=361600&exclude_vehicle_id%5B16%5D=361601&exclude_vehicle_id%5B17%5D=361606&exclude_vehicle_id%5B18%5D=361659&exclude_vehicle_id%5B19%5D=361663&exclude_vehicle_id%5B20%5D=361666&exclude_vehicle_id%5B21%5D=361679&exclude_vehicle_id%5B22%5D=361798&exclude_vehicle_id%5B23%5D=361800'
        )->json();

        if (! isset($response['data']['items'])) {
            throw new Exception('Б/У машины не получены');
        }

        $items = $response['data']['items'];

        $count = count($items);
        $bar = $this->output->createProgressBar($count);
        $this->info("Создание {$count} автомобилей");

        foreach ($items as $i => $item) {
            if ($i >= 400) {
                return;
            }

            $newCar = new Car;
            $newCar->mark = $item['brand']['name'] ?? 'unknown';
            $newCar->model = $item['model']['name'] ?? 'unknown';
            $newCar->year = $item['year'] ?? 2010;
            $newCar->color = $item['color_name'] ?? '#000';
            $newCar->type = $i % 2 === 0 ? CarType::USED : CarType::NEW;
            $newCar->price = $item['price'] ?? 1000000;
            $newCar->vin_code = $item['vin'][0] ?? Str::uuid()->toString();
            $newCar->state_number = null;
            $newCar->class = 'B';
            $newCar->count = $item['count'] ?? 1;
            $newCar->save();

            if (isset($item['images'])) {
                $images = array_map(fn (array $item) => $item['url'], $item['images']);
                $newCar->addMultipleFromUrl($images);
                $newCar->save();
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
