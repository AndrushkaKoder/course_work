<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CreditApplication\Pages;

use App\Enums\CreditApplication\CreditApplicationStatus;
use App\Models\CreditApplication;
use App\MoonShine\Resources\CreditApplication\CreditApplicationResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends DetailPage<CreditApplicationResource>
 */
class CreditApplicationDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make('ID', 'id'),
            Text::make('Статус', 'status', function (CreditApplication $item) {
                return $item->status?->formattedValue() ?? 'В обработке';
            })
                ->badge(function ($value, $field) {
                    $application = $field->getData()->getOriginal();

                    if (! $application instanceof CreditApplication) {
                        return 'gray';
                    }

                    return match ($application->status) {
                        null => 'warning',
                        CreditApplicationStatus::SUCCESS => 'success',
                        CreditApplicationStatus::FAILED => 'error',
                    };
                }),
            Text::make('Сумма', 'sum', fn (CreditApplication $item) => $item->formattedSum()),
            Text::make('Процентная ставка', 'percent', fn (CreditApplication $item) => $item->formattedPercent()),
            Text::make('Менеджер', 'user.name', fn (CreditApplication $item) => $item->user?->name ?? '—'),
            Text::make('Клиент', 'client.name', fn (CreditApplication $item) => $item->client->name),
            Text::make('Телефон', 'client.phone', fn (CreditApplication $item) => $item->client->phone),
            File::make('Документы', 'files')->multiple(),
            Text::make('Причина отказа', 'cancel_reason', fn (CreditApplication $item) => $item->cancel_reason ?? '—'),
            Date::make('Дата создания', 'created_at'),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @param  TableBuilder  $component
     */
    protected function modifyDetailComponent(ComponentContract $component): ComponentContract
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
