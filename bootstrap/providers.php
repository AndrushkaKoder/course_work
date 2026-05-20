<?php

use App\Providers\AppServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\MoonShineServiceProvider;
use App\Providers\PermissionsServiceProvider;

return [
    AppServiceProvider::class,
    PermissionsServiceProvider::class,
    HorizonServiceProvider::class,
    MoonShineServiceProvider::class,
];
