<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sail\Pages\Buy;

use App\Enums\Car\CarType;
use App\Enums\Sail\SailStatus;
use App\Enums\Sail\SailType;
use App\Models\Client;
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
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
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
        return [
            Box::make([
                Tabs::make([
                    Tabs\Tab::make('Сделка', [

                        Select::make('status', 'status')
                            ->options(SailStatus::getValues()),

                        Hidden::make('type', 'type')
                            ->setValue(SailType::BUY->value)
                            ->required(),

                        Select::make('Клиент', 'client_id')
                            ->options(Client::query()->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->required(),

                        Number::make('Стоимость', 'price')
                            ->required(),

                        File::make('Документы', 'files')
                            ->multiple()
                            ->removable()
                            ->hint('Договор купли-продажи и сопутствующие документы')
                            ->required(! $this->getItem()?->exists),
                    ]),
                    Tabs\Tab::make('Автомобиль', [
                        Select::make('Тип', 'car[type]')->options([
                            CarType::USED->value => 'Б/У',
                        ])->required(),
                        Text::make('Марка', 'car.mark')->required(),
                        Text::make('Модель', 'car.model')->required(),
                        Number::make('Год', 'car.year')->required(),
                        Number::make('Пробег', 'car.mileage')->required(),
                        Text::make('VIN', 'car.vin_code')->required(),
                        Color::make('Цвет', 'car.color')->required(),
                        Image::make('Превью', 'car.preview')->required(! $this->getItem()?->exists),
                        Image::make('Изображения', 'car.files')->multiple()->required(! $this->getItem()?->exists),
                    ]),
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
