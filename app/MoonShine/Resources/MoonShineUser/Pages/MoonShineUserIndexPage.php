<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MoonShineUser\Pages;

use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<MoonShineUserResource>
 */
final class MoonShineUserIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make(__('moonshine::ui.resource.name'), 'name'),
            Email::make(__('moonshine::ui.resource.email'), 'email')->sortable(),
            Date::make(__('moonshine::ui.resource.created_at'), 'created_at')
                ->format('d.m.Y')
                ->sortable(),
        ];
    }

    protected function filters(): iterable
    {
        return [
            Email::make('E-mail', 'email'),
        ];
    }

    /**
     * @param  TableBuilder  $component
     */
    protected function modifyListComponent(ComponentContract $component): TableBuilder
    {
        return $component->columnSelection();
    }
}
