<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sail\Pages\Buy;

use App\Enums\Sail\SailStatus;
use App\Models\Sail;
use App\MoonShine\Resources\Sail\SailBuyResource;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends IndexPage<SailBuyResource>
 */
class SailIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Статус', 'status', function ($item) {
                return $item->status->formattedValue();
            })
                ->badge(function ($value, $field) {
                    $sail = $field->getData()->getOriginal();

                    if (! $sail instanceof Sail) {
                        return 'gray';
                    }

                    return match ($sail->status) {
                        SailStatus::PENDING => 'warning',
                        SailStatus::COMPLETED => 'success',
                        SailStatus::CANCELLED => 'error',
                    };
                }),
            Date::make('Дата', 'created_at'),
            Text::make('Автомобиль', 'car', function (Sail $s) {
                return $s->car->getViewName();
            }),
            Text::make('Сумма', 'price', fn (Sail $s) => $s->formattedPrice()),
            Text::make('Клиент', 'client.name', fn (Sail $s) => "{$s->client->name} ({$s->client_id})"),
            Text::make('Продавец', 'user.name', fn (Sail $s) => "{$s->user->name} ({$s->user_id})"),
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
