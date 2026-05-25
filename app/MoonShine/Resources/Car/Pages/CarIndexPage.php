<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Car\Pages;

use App\Models\Car;
use App\MoonShine\Resources\Car\CarUsedResource;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
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
            Image::make('Превью', 'preview', function (Car $car) {
                if (! $car->preview) {
                    return $car->getFiles()[0] ?? null;
                }

                return $car->preview;
            }),
            Text::make('Модель', 'model'),
            Text::make('Марка', 'mark'),
            Text::make('Цена', 'price', fn (Car $car) => $car->getViewPrice()),
            Text::make('Год', 'year'),
            Text::make('VIN', 'vin_code'),
            Text::make('Цвет', 'color'),
            Text::make('Статус', 'status', fn (Car $car): string => $car->formattedStatus()),
            Text::make('Дата добавления', 'created_at'),

        ];
    }

    /**
     * @return ListOf<ActionButtonContract>
     */
    protected function buttons(): ListOf
    {
        return parent::buttons();
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
     * @param  TableBuilder  $component
     * @return TableBuilder
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer(),
        ];
    }
}
