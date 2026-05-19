<?php

namespace App\Console\Commands;

use App\Enums\Car\CarColor;
use App\Enums\Car\CarType;
use App\Models\Car;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

#[Signature('app:car-parser')]
#[Description('Command description')]
class CarParser extends Command
{
    public function handle(): void
    {
        //        if (Car::count()) {
        //            $this->error('Список машин уже заполнен');
        //
        //            return;
        //        }

        $response = Http::post('https://cars.lego-car.ru/api/v1/filter/', [
            //            'page' => 2,
            'car_type' => [
                0 => 'c пробегом',
            ],
            'opened' => [
                0 => 'car_type',
                1 => 'brand',
            ],
        ])->json();



        $count = count($response['data'] ?? []);
        $bar = $this->output->createProgressBar($count);
        $this->info("Создание {$count} автомобилей");

        $cars = $this->getCar($response);

        foreach ($cars as $car) {
            $stateNumber = $car['type'] === CarType::USED->value ? Str::random(10) : null;
            $newCar = new Car;

            $newCar->mark = $car['mark'];
            $newCar->model = $car['model'];
            $newCar->year = $car['year'];
            $newCar->color = $car['color'];
            $newCar->type = $car['type'];
            $newCar->price = $car['price'];
            $newCar->vin_code = $car['vin_code'];
            $newCar->state_number = $stateNumber;
            $newCar->class = $car['class'];
            $newCar->count = rand(1, 10);
            $newCar->save();

            $bar->advance();
        }

        $bar->finish();

    }

    private function getCar(array $data): \Iterator
    {
        $colors = CarColor::getValues();
        $types = CarType::getValues();

        foreach ($data['data'] ?? [] as $mark) {
            foreach ($mark['models'] ?? [] as $model) {
                yield [
                    'mark' => $mark['name'],
                    'model' => $model['name'],
                    'year' => $model['year_from'],
                    'class' => $model['class'],
                    'price' => rand(50000, 10000000),
                    'color' => $colors[rand(0, count($colors) - 1)],
                    'type' => $types[rand(0, count($types) - 1)],
                    'vin_code' => Str::uuid()->toString(),
                ];
            }
        }
    }
}
