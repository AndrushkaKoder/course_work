<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CreditApplication;

use App\Models\CreditApplication;
use App\MoonShine\Resources\CreditApplication\Pages\CreditApplicationDetailPage;
use App\MoonShine\Resources\CreditApplication\Pages\CreditApplicationFormPage;
use App\MoonShine\Resources\CreditApplication\Pages\CreditApplicationIndexPage;
use App\Services\CreditApplicationService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<CreditApplication, CreditApplicationIndexPage, CreditApplicationFormPage, CreditApplicationDetailPage>
 */
class CreditApplicationResource extends ModelResource
{
    protected string $model = CreditApplication::class;

    protected string $title = 'Заявки на кредит';

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder->where('user_id', Auth::id())->with(['client', 'user']);
    }

    protected function modifyItemQueryBuilder(Builder $builder): Builder
    {
        return $this->applyManagerScope($builder);
    }

    public function applyManagerScope(Builder $builder): Builder
    {
        $userId = Auth::guard(config('moonshine.auth.guard'))->id();

        if ($userId !== null) {
            $builder->where('user_id', $userId);
        }

        return $builder;
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CreditApplicationIndexPage::class,
            CreditApplicationFormPage::class,
            CreditApplicationDetailPage::class,
        ];
    }

    protected function search(): array
    {
        return ['cancel_reason', 'client.name', 'client.phone'];
    }

    public function save(DataWrapperContract $item, ?FieldsContract $fields = null): DataWrapperContract
    {
        $application = $item->getOriginal();
        $service = app(CreditApplicationService::class);

        $service->updateOrCreate(
            $application instanceof CreditApplication ? $application : null,
            request()->all(),
        );

        return $item;
    }
}
