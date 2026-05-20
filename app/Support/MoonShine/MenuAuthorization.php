<?php

declare(strict_types=1);

namespace App\Support\MoonShine;

use App\Models\User;
use App\Traits\HasUserPermissions;
use MoonShine\Contracts\Core\ResourceContract;
use MoonShine\Laravel\MoonShineAuth;
use MoonShine\Support\Enums\Ability;

final class MenuAuthorization
{
    /**
     * @param  class-string<ResourceContract>  $resourceClass
     */
    public static function can(string $resourceClass, Ability $ability = Ability::VIEW_ANY): bool
    {
        $user = MoonShineAuth::getGuard()->user();

        if (! $user instanceof User) {
            return false;
        }

        if ($user->isSuperUser()) {
            return true;
        }

        if (! in_array(HasUserPermissions::class, class_uses_recursive($user), true)) {
            return false;
        }

        if ($ability === Ability::VIEW_ANY) {
            return $user->canAccessResource($resourceClass);
        }

        return $user->isHavePermission($resourceClass, $ability);
    }
}
