<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MoonShineUser\Pages;

use App\Models\User;
use App\Models\UserRole;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\UserRole\UserRoleResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Text;

/**
 * @extends FormPage<MoonShineUserResource, User>
 */
final class MoonShineUserFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('moonshine::ui.resource.main_information'), [
                        ID::make(),

                        BelongsTo::make(
                            __('moonshine::ui.resource.role'),
                            'userRole',
                            formatted: static fn (UserRole $model): string => $model->name,
                            resource: UserRoleResource::class,
                        )
                            ->required()
                            ->valuesQuery(static fn (Builder $query): Builder => $query->select(['id', 'name'])),

                        Flex::make([
                            Text::make(__('moonshine::ui.resource.name'), 'name')
                                ->required(),

                            Email::make(__('moonshine::ui.resource.email'), 'email')
                                ->required(),
                        ]),
                    ])->icon('user-circle'),

                    Tab::make(__('moonshine::ui.resource.password'), [
                        Collapse::make(__('moonshine::ui.resource.change_password'), [
                            Password::make(__('moonshine::ui.resource.password'), 'password')
                                ->customAttributes(['autocomplete' => 'new-password'])
                                ->eye(),

                            PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_confirmation')
                                ->customAttributes(['autocomplete' => 'confirm-password'])
                                ->eye(),
                        ])->icon('lock-closed'),
                    ])->icon('lock-closed'),
                ]),
            ]),
        ];
    }

    protected function prepareBeforeRender(): void
    {
        parent::prepareBeforeRender();

        $resource = $this->getResource();

        if ($resource instanceof MoonShineUserResource) {
            $resource->loadWithPermissions();
        }
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'user_role_id' => ['required', 'exists:user_roles,id'],
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique($item->getOriginal()::class)->ignoreModel($item->getOriginal()),
            ],
            'password' => [
                ...$item->getKey() !== null ? ['sometimes', 'nullable'] : ['required'],
                PasswordRule::defaults(),
                'confirmed',
            ],
        ];
    }
}
