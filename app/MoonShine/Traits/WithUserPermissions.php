<?php

declare(strict_types=1);

namespace App\MoonShine\Traits;

use App\Models\UserRole;
use MoonShine\Laravel\MoonShineAuth;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Permissions\Components\Permissions;
use MoonShine\Support\Enums\Layer;

/**
 * @mixin ModelResource
 */
trait WithUserPermissions
{
    public function loadWithPermissions(): void
    {
        $this->getFormPage()
            ?->pushToLayer(
                Layer::BOTTOM,
                Permissions::make(
                    __('moonshine-permissions::permissions.title'),
                    $this,
                )->canSee(
                    fn (): bool => MoonShineAuth::getGuard()->user()?->user_role_id === UserRole::ADMIN_ID,
                ),
            );
    }
}
