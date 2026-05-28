<?php

declare(strict_types=1);

namespace App\Providers;

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
use App\Traits\HasUserPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Contracts\Core\ResourceContract;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use MoonShine\Support\Enums\Ability;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core, MoonShineConfigurator $config): void
    {
        $config->authorizationRules(
            static function (
                ResourceContract $resource,
                Model $user,
                Ability $ability,
                Model $item,
            ): bool {
                if (! $user instanceof User) {
                    return false;
                }

                if (in_array($resource::class, [
                    MoonShineUserResource::class,
                    UserRoleResource::class,
                    ReportResource::class,
                ], true)) {
                    return $user->isSuperUser();
                }

                if ($user->isSuperUser()) {
                    return true;
                }

                if (! in_array(HasUserPermissions::class, class_uses_recursive($user), true)) {
                    return false;
                }

                if ($ability === Ability::VIEW_ANY) {
                    return $user->canAccessResource($resource::class);
                }

                return $user->isHavePermission($resource::class, $ability);
            },
        );

        // В PHPUnit ConfiguratorContract — bind, а не singleton: один экземпляр с правилами.
        $this->app->singleton(ConfiguratorContract::class, static fn (): ConfiguratorContract => $config);

        $core
            ->resources([
                MoonShineUserResource::class,
                UserRoleResource::class,
                CarNewResource::class,
                CarUsedResource::class,
                SailBuyResource::class,
                SailSellResource::class,
                ClientResource::class,
                CreditApplicationResource::class,
                OptionResource::class,
                ReportResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ]);
    }
}
