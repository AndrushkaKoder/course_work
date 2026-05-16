<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\Car\CarNewResource;
use App\MoonShine\Resources\Sail\SailSellResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Resources\Car\CarUsedResource;
use App\MoonShine\Resources\Sail\SailBuyResource;
use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\Option\OptionResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                CarNewResource::class,
                CarUsedResource::class,
                SailBuyResource::class,
                SailSellResource::class,
                ClientResource::class,
                OptionResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ])
        ;
    }
}
