<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Report\Pages;

use App\Enums\Sail\SailType;
use App\MoonShine\Resources\Report\ReportResource;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Select;

/**
 * @extends FormPage<ReportResource>
 */
final class ReportFormPage extends FormPage
{
    /**
     * @return list<ComponentContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Select::make('Тип сделки', 'type')
                    ->options(SailType::values())
                    ->required(),

                Date::make('Период с', 'from')
                    ->required(),

                Date::make('Период по', 'to')
                    ->required(),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'type' => ['required', 'integer', Rule::enum(SailType::class)],
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ];
    }
}
