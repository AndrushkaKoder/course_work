<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\UserRole;

use App\Models\UserRole;
use App\MoonShine\Resources\UserRole\Pages\UserRoleFormPage;
use App\MoonShine\Resources\UserRole\Pages\UserRoleIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<UserRole, UserRoleIndexPage, UserRoleFormPage, null>
 */
#[Icon('bookmark')]
#[Group('moonshine::ui.resource.system', 'users', translatable: true)]
#[Order(1)]
class UserRoleResource extends ModelResource
{
    protected string $model = UserRole::class;

    protected string $column = 'name';

    protected bool $createInModal = true;

    protected bool $detailInModal = true;

    protected bool $editInModal = true;

    protected bool $cursorPaginate = true;

    public function getTitle(): string
    {
        return __('moonshine::ui.resource.role');
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function pages(): array
    {
        return [
            UserRoleIndexPage::class,
            UserRoleFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
