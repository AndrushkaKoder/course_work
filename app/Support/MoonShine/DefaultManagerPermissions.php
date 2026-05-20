<?php

declare(strict_types=1);

namespace App\Support\MoonShine;

use App\Models\User;
use App\Models\UserRole;
use App\MoonShine\Resources\Car\CarNewResource;
use App\MoonShine\Resources\Car\CarUsedResource;
use App\MoonShine\Resources\Client\ClientResource;
use App\MoonShine\Resources\CreditApplication\CreditApplicationResource;
use App\MoonShine\Resources\Option\OptionResource;
use App\MoonShine\Resources\Sail\SailBuyResource;
use App\MoonShine\Resources\Sail\SailSellResource;
use MoonShine\Support\Enums\Ability;

final class DefaultManagerPermissions
{
    /**
     * @return array<class-string, list<Ability>>
     */
    private static function map(): array
    {
        return [
            CreditApplicationResource::class => [
                Ability::VIEW_ANY,
                Ability::VIEW,
                Ability::CREATE,
                Ability::UPDATE,
                Ability::DELETE,
            ],
            ClientResource::class => [
                Ability::VIEW_ANY,
                Ability::VIEW,
                Ability::CREATE,
                Ability::UPDATE,
            ],
            OptionResource::class => [
                Ability::VIEW_ANY,
                Ability::VIEW,
            ],
            CarNewResource::class => [
                Ability::VIEW_ANY,
                Ability::VIEW,
            ],
            CarUsedResource::class => [
                Ability::VIEW_ANY,
                Ability::VIEW,
            ],
            SailSellResource::class => [
                Ability::VIEW_ANY,
                Ability::VIEW,
                Ability::CREATE,
                Ability::UPDATE,
            ],
            SailBuyResource::class => [
                Ability::VIEW_ANY,
                Ability::VIEW,
                Ability::CREATE,
                Ability::UPDATE,
            ],
        ];
    }

    public static function allows(User $user, string $resourceClass, Ability $ability): bool
    {
        if ($user->user_role_id !== UserRole::MANAGER_ID) {
            return false;
        }

        $abilities = self::map()[$resourceClass] ?? [];

        return in_array($ability, $abilities, true);
    }

    /**
     * @return array<string, array<string, bool>>
     */
    public static function toPermissionsArray(): array
    {
        $permissions = [];

        foreach (self::map() as $resourceClass => $abilities) {
            foreach ($abilities as $ability) {
                $permissions[$resourceClass][$ability->value] = true;
            }
        }

        return $permissions;
    }
}
