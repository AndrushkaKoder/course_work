<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CarService;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function index(CarService $service): View
    {

        $list = $service->getAllCars();

        return view(
            'pages::index',
            [
                'cars' => $list->allCars,
                'newCars' => $list->newCars,
                'usedCars' => $list->usedCars,
            ]
        );
    }
}
