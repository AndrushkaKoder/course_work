<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use App\Models\UserPermission;
use App\Support\MoonShine\DefaultManagerPermissions;
use Illuminate\Database\Eloquent\Relations\HasOne;
use MoonShine\Support\Enums\Ability;

trait HasUserPermissions
{
    public function isHavePermission(string $resourceClass, Ability $ability): bool
    {
        $permissions = $this->userPermission?->permissions; // @phpstan-ignore-line

        if ($permissions !== null) {
            return (bool) data_get($permissions, $resourceClass.'.'.$ability->value, false);
        }

        if ($this instanceof User) {
            return DefaultManagerPermissions::allows($this, $resourceClass, $ability);
        }

        return false;
    }

    public function canAccessResource(string $resourceClass): bool
    {
        return $this->isHavePermission($resourceClass, Ability::VIEW_ANY)
            || $this->isHavePermission($resourceClass, Ability::VIEW);
    }

    public function userPermission(): HasOne
    {
        return $this->hasOne(UserPermission::class);
    }
}
