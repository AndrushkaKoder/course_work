<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\Car\CarNewResource;
use App\MoonShine\Resources\Car\CarUsedResource;
use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\Sail\SailBuyResource;
use App\MoonShine\Resources\Sail\SailSellResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\Option\OptionResource;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make(ClientResource::class, 'Клиенты'),
            MenuItem::make(OptionResource::class, 'Доп.опции'),
            MenuGroup::make('Автомобили', [
                MenuItem::make(CarNewResource::class, 'Новые'),
                MenuItem::make(CarUsedResource::class, 'С пробегом'),
            ]),
            MenuGroup::make('Сделки', [
                MenuItem::make(SailSellResource::class, 'Продажа'),
                MenuItem::make(SailBuyResource::class, 'Покупка'),
            ]),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);
    }
}
