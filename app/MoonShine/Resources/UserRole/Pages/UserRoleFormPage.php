<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\UserRole\Pages;

use App\Models\UserRole;
use App\MoonShine\Resources\UserRole\UserRoleResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends FormPage<UserRoleResource, UserRole>
 */
final class UserRoleFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make(__('moonshine::ui.resource.role_name'), 'name')
                    ->required(),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
        ];
    }
}
