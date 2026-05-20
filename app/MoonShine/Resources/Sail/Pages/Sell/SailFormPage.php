<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sail\Pages\Sell;

use App\Enums\Sail\SailStatus;
use App\Enums\Sail\SailType;
use App\Models\Car;
use App\Models\Client;
use App\Models\Option;
use App\Models\Sail;
use App\MoonShine\Resources\Sail\SailBuyResource;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Contracts\Container\CircularDependencyException;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

/**
 * @extends FormPage<SailBuyResource>
 */
class SailFormPage extends FormPage
{
    /**
     * @throws EntryNotFoundException
     * @throws CircularDependencyException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function fields(): iterable
    {
        $options = Option::query()
            ->orderByDesc('id')
            ->get();

        $cars = Car::query()
            ->where('count', '>', 0)
            ->orderByDesc('id')
            ->get();

        $optionsMap = $options->pluck('price', 'id')->toArray();
        $optionsValues = $options->pluck('title', 'id')->toArray();
        $carsPricesMap = [];

        $carsList = ['' => 'Выберите автомобиль'];

        if ($item = $this->resource->getItem()) {
            $car = $item->car;
            if ($car !== null) {
                $carsList[$car->id] = $car->getCarSailInfo();
            }
        } else {
            foreach ($cars as $car) {
                $carsList[$car->id] = $car->getCarSailInfo();
                $carsPricesMap[$car->id] = $car->price;
            }
        }

        return [
            Box::make([
                Select::make('status', 'status')
                    ->options(SailStatus::getValues()),

                Hidden::make('type', 'type')
                    ->setValue(SailType::SELL->value)
                    ->changeFill(static fn (mixed $item): int => $item instanceof Sail
                        ? SailType::toFormValue($item->type, SailType::SELL)
                        : SailType::SELL->value)
                    ->required(),

                Select::make('Автомобиль', 'car_id')
                    ->options($carsList)
                    ->searchable()
                    ->required()
                    ->customAttributes([
                        'data-car-prices' => json_encode($carsPricesMap),
                        'x-init' => "
                        \$nextTick(() => {
                            // Находим селект внутри обертки TomSelect/Choices
                            let selectEl = \$el.querySelector('select') || \$el;
                            let control = selectEl.tomselect || selectEl.choices;
                            let priceInput = document.querySelector('input[name=\"price\"]');
                            let carPrices = JSON.parse(selectEl.dataset.carPrices || '{}');

                            if (!priceInput) return;

                            let setCarPrice = (carId) => {
                                // Просто берем цену из карты и затираем старое значение в инпуте
                                priceInput.value = parseFloat(carPrices[carId]) || 0;
                                priceInput.dispatchEvent(new Event('input', { bubbles: true }));
                            };

                            // Перехватываем выбор автомобиля (работает и для TomSelect, и для Choices)
                            if (control && selectEl.tomselect) {
                                control.on('change', (value) => setCarPrice(value));
                            } else {
                                selectEl.addEventListener('change', () => {
                                    let value = control ? control.getValue() : selectEl.value;
                                    setCarPrice(value);
                                });
                            }
                        });
                    ",
                    ]),

                Select::make('Клиент', 'client_id')
                    ->options(Client::query()->pluck('name', 'id')->toArray())
                    ->searchable(),

                Number::make('Стоимость', 'price')->required(),

                File::make('Документы', 'files')
                    ->multiple()
                    ->removable()
                    ->hint('Договор купли-продажи и сопутствующие документы')
                    ->required(! $this->getItem()?->exists),

                Select::make('Список опций', 'options')
                    ->options($optionsValues)
                    ->searchable()
                    ->multiple()
                    ->customAttributes([
                        'data-prices' => json_encode($optionsMap),
                        'x-init' => "
                        \$nextTick(() => {
                            let selectEl = \$el.querySelector('select') || \$el;
                            let control = selectEl.tomselect || selectEl.choices;
                            let priceInput = document.querySelector('input[name=\"price\"]');
                            let prices = JSON.parse(selectEl.dataset.prices || '{}');

                            if (!priceInput) return;

                            let modifyPrice = (amount) => {
                                let currentPrice = parseFloat(priceInput.value) || 0;
                                priceInput.value = Math.max(0, currentPrice + amount);
                                priceInput.dispatchEvent(new Event('input', { bubbles: true }));
                            };

                            if (control && selectEl.tomselect) {
                                control.on('item_add', (value) => modifyPrice(parseFloat(prices[value]) || 0));
                                control.on('item_remove', (value) => modifyPrice(-parseFloat(prices[value]) || 0));
                            } else {
                                selectEl.addEventListener('addItem', (e) => modifyPrice(parseFloat(prices[e.detail.value]) || 0));
                                selectEl.addEventListener('removeItem', (e) => modifyPrice(-parseFloat(prices[e.detail.value]) || 0));
                            }
                        });
                    ",
                    ]),
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
        return [];
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
