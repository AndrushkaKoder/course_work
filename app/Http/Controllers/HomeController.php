<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Car\CarType;
use App\Models\Car;
use Illuminate\Support\Collection;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        $cars = Car::query()
            ->where('count', '>', 0)
            ->orderByDesc('created_at')
            ->get();

        /** @var Collection<int, Car> $newCars */
        $newCars = $cars->filter(fn (Car $car) => $car->type === CarType::NEW)->values();

        /** @var Collection<int, Car> $usedCars */
        $usedCars = $cars->filter(fn (Car $car) => $car->type === CarType::USED)->values();

        return view('pages::index', compact('cars', 'newCars', 'usedCars'));
    }
}
