<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sail\Pages;

use App\Models\Car;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Contracts\Container\CircularDependencyException;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\Sail\SailResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;


/**
 * @extends FormPage<SailResource>
 */
class SailFormPage extends FormPage
{

    /**
     * @return iterable
     * @throws EntryNotFoundException
     * @throws CircularDependencyException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function fields(): iterable
    {
        $car = Car::query()->find(request()->get('car_id'));

        if (!$car) {
            abort(403, 'Выберите автомобиль для сделки');
        }

        return [
            Box::make([
                BelongsTo::make('Клиент', 'client', 'name')
                    ->nullable()
                    ->searchable()
                    ->placeholder('Выбрать клиента'),
                Select::make('Автомобиль', 'car_id')
                    ->options([
                        request()->car_id => $car->getViewName(),
                    ]),
                Number::make('Цена', 'price')
                ->default($car->price)
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
     * @param FormBuilder $component
     *
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
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
