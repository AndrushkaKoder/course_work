<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CreditApplication\Pages;

use App\Models\Client;
use App\Models\CreditApplication;
use App\MoonShine\Resources\CreditApplication\CreditApplicationResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use Throwable;

/**
 * @extends FormPage<CreditApplicationResource>
 */
class CreditApplicationFormPage extends FormPage
{
    /**
     * @return list<ComponentContract>
     */
    protected function fields(): iterable
    {
        /**
         * @var CreditApplication $item
         */
        $item = $this->getItem();

        $client = $item?->client;

        return [
            Box::make([
                Select::make('Клиент', 'client_id')
                    ->options(Client::query()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),

                Number::make('Сумма кредита', 'sum')
                    ->min(1)
                    ->required(),

                Text::make('Серия паспорта', 'passport_series')
                    ->default($client?->passport_series)
                    ->hint('Заполняется в карточку клиента, если поле пусто'),

                Text::make('Номер паспорта', 'passport_number')
                    ->default($client?->passport_number)
                    ->hint('Заполняется в карточку клиента, если поле пусто'),

                File::make('Документы', 'files')
                    ->multiple()
                    ->removable()
                    ->hint('Паспорт и сопутствующие документы')
                    ->required(! $this->getItem()?->exists),
            ]),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'sum' => ['required', 'integer', 'min:1'],
            'passport_series' => ['required', 'numeric'],
            'passport_number' => ['required', 'numeric'],
        ];
    }

    /**
     * @param  FormBuilder  $component
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
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
