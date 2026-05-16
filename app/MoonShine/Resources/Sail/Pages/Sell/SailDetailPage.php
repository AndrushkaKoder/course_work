<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sail\Pages\Sell;

use App\Enums\Sail\SailStatus;
use App\Models\Sail;
use App\MoonShine\Resources\Sail\SailBuyResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends DetailPage<SailBuyResource>
 */
class SailDetailPage extends DetailPage
{
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
                ->badge(fn($value, $field) => match ($field->getData()->status) {
                    SailStatus::PENDING => 'warning',
                    SailStatus::COMPLETED => 'success',
                    SailStatus::CANCELLED => 'error',
                    default => 'gray',
                }),
            Date::make('Дата', 'created_at'),
            Text::make('Автомобиль', 'car', function (Sail $s) {
                return $s->car->getViewName();
            }),
            Text::make('Сумма', 'price', fn(Sail $s) => $s->formattedPrice()),
            Text::make('Клиент', 'client.name', fn(Sail $s) => "{$s->client->name} ({$s->client_id})"),
            Text::make('Продавец', 'user.name', fn(Sail $s) => "{$s->user->name} ({$s->user_id})"),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @param  TableBuilder  $component
     *
     * @return TableBuilder
     */
    protected function modifyDetailComponent(ComponentContract $component): ComponentContract
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
