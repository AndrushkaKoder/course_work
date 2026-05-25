<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\Models\User;
use App\MoonShine\Resources\Car\CarNewResource;
use App\MoonShine\Resources\Car\CarUsedResource;
use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\CreditApplication\CreditApplicationResource;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\Option\OptionResource;
use App\MoonShine\Resources\Report\ReportResource;
use App\MoonShine\Resources\Sail\SailBuyResource;
use App\MoonShine\Resources\Sail\SailSellResource;
use App\MoonShine\Resources\UserRole\UserRoleResource;
use App\Support\MoonShine\MenuAuthorization;
use MoonShine\ColorManager\ColorManager;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\MoonShineAuth;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

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
        $user = MoonShineAuth::getGuard()->user();
        $isAdmin = $user instanceof User && $user->isSuperUser();

        $menu = [];

        if ($isAdmin) {
            $menu[] = MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                MenuItem::make(MoonShineUserResource::class),
                MenuItem::make(UserRoleResource::class),
                MenuItem::make(ReportResource::class, 'Отчёты'),
            ]);
        }

        return [
            ...$menu,
            MenuItem::make(CreditApplicationResource::class, 'Кредитные заявки')
                ->canSee(static fn (): bool => MenuAuthorization::can(CreditApplicationResource::class)),
            MenuItem::make(ClientResource::class, 'Клиенты')
                ->canSee(static fn (): bool => MenuAuthorization::can(ClientResource::class)),
            MenuItem::make(OptionResource::class, 'Доп.опции')
                ->canSee(static fn (): bool => MenuAuthorization::can(OptionResource::class)),
            MenuGroup::make('Автомобили', [
                MenuItem::make(CarNewResource::class, 'Новые')
                    ->canSee(static fn (): bool => MenuAuthorization::can(CarNewResource::class)),
                MenuItem::make(CarUsedResource::class, 'С пробегом')
                    ->canSee(static fn (): bool => MenuAuthorization::can(CarUsedResource::class)),
            ])->canSee(static fn (): bool => MenuAuthorization::can(CarNewResource::class)
                || MenuAuthorization::can(CarUsedResource::class)),
            MenuGroup::make('Сделки', [
                MenuItem::make(SailSellResource::class, 'Продажа')
                    ->canSee(static fn (): bool => MenuAuthorization::can(SailSellResource::class)),
                MenuItem::make(SailBuyResource::class, 'Покупка')
                    ->canSee(static fn (): bool => MenuAuthorization::can(SailBuyResource::class)),
            ])->canSee(static fn (): bool => MenuAuthorization::can(SailSellResource::class)
                || MenuAuthorization::can(SailBuyResource::class)),
        ];
    }

    /**
     * @param  ColorManager  $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);
    }
}
