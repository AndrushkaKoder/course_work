<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Car\Pages;

use App\Enums\Car\CarType;
use App\Models\Car;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\ID;
use App\MoonShine\Resources\Car\CarUsedResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends IndexPage<CarUsedResource>
 */
class CarIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Image::make('Превью', 'preview'),
            Text::make('Модель', 'model'),
            Text::make('Марка', 'mark'),
            Text::make('Цена', 'price', fn(Car $car) => $car->getViewPrice()),
            Text::make('Год', 'year'),
            Text::make('VIN', 'vin_code'),
            Color::make('Цвет', 'color'),
            Number::make('На складе', 'count'),
            Text::make('ГРЗ', 'state_number')->showWhen('type', '=', CarType::USED),
            Text::make('Дата добавления', 'created_at'),

        ];
    }

    /**
     * @return ListOf<ActionButtonContract>
     */
    protected function buttons(): ListOf
    {
        return parent::buttons()
            ->prepend(
                ActionButton::make(
                    '',
                    function (Car $car) {
                        return url('admin/resource/sail-resource/sail-form-page?car_id=' . $car->id);
                    }
                )->canSee(fn(Car $car) => $car->count >= 1)
                    ->icon('currency-dollar')
                    ->success()
                    ->content('сделка'),
            );
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [];
    }

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [];
    }

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [];
    }

    /**
     * @param TableBuilder $component
     *
     * @return TableBuilder
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }

}
