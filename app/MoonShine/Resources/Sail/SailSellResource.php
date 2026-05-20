<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Sail;

use App\Enums\Sail\SailType;
use App\Models\Sail;
use App\MoonShine\Resources\Sail\Pages\Sell\SailDetailPage;
use App\MoonShine\Resources\Sail\Pages\Sell\SailFormPage;
use App\MoonShine\Resources\Sail\Pages\Sell\SailIndexPage;
use App\Services\SailService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;

class SailSellResource extends ModelResource
{
    protected string $model = Sail::class;

    protected string $title = 'Продажа Авто';

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder
            ->where('user_id', Auth::id())
            ->where('type', SailType::SELL);
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            SailIndexPage::class,
            SailFormPage::class,
            SailDetailPage::class,
        ];
    }

    public function save(DataWrapperContract $item, ?FieldsContract $fields = null): DataWrapperContract
    {
        $sail = $item->getOriginal();
        $service = app(SailService::class);

        $service->updateOrCreate($sail instanceof Sail ? $sail : null, request()->all());

        return $item;
    }
}
