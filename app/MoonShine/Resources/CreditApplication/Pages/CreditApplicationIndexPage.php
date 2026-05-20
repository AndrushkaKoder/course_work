<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CreditApplication\Pages;

use App\Enums\CreditApplication\CreditApplicationStatus;
use App\Models\CreditApplication;
use App\MoonShine\Resources\CreditApplication\CreditApplicationResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
 * @extends IndexPage<CreditApplicationResource>
 */
class CreditApplicationIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    public function prepareBeforeRender(): void
    {
        parent::prepareBeforeRender();

        $this->getResource()->customQueryBuilder(
            $this->modifyQueryBuilder($this->getResource()->getModel()->newQuery()),
        );
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        $resource = $this->getResource();

        if ($resource instanceof CreditApplicationResource) {
            return $resource->applyManagerScope($builder);
        }

        return $builder;
    }

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Клиент', 'client.name'),
            Text::make('Сумма', 'sum', fn (CreditApplication $item) => $item->formattedSum()),
            Text::make('Менеджер', 'user.name', fn (CreditApplication $item) => $item->user?->name ?? '—'),
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
            Date::make('Дата', 'created_at'),
        ];
    }

    /**
     * @return ListOf<ActionButtonContract>
     */
    protected function buttons(): ListOf
    {
        return new ListOf(ActionButtonContract::class, [
            $this->modifyDetailButton(
                $this->getResource()->getDetailButton(),
            ),
            $this->modifyDeleteButton(
                $this->getResource()->getDeleteButton(
                    redirectAfterDelete: $this->getResource()->getRedirectAfterDelete(),
                    isAsync: $this->isAsync(),
                ),
            ),
            $this->modifyMassDeleteButton(
                $this->getResource()->getMassDeleteButton(
                    redirectAfterDelete: $this->getResource()->getRedirectAfterDelete(),
                    isAsync: $this->isAsync(),
                ),
            ),
        ]);
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
