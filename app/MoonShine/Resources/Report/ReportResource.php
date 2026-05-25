<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Report;

use App\DTO\CreateReportDto;
use App\Enums\Sail\SailType;
use App\Models\Report;
use App\MoonShine\Resources\Report\Pages\ReportDetailPage;
use App\MoonShine\Resources\Report\Pages\ReportFormPage;
use App\MoonShine\Resources\Report\Pages\ReportIndexPage;
use App\Services\ReportService;
use Illuminate\Support\Carbon;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Report, ReportIndexPage, ReportFormPage, ReportDetailPage>
 */
#[Icon('document-chart-bar')]
#[Group('moonshine::ui.resource.system', 'users', translatable: true)]
#[Order(5)]
class ReportResource extends ModelResource
{
    protected string $model = Report::class;

    protected string $title = 'Отчёты';

    protected array $with = ['user'];

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ReportIndexPage::class,
            ReportFormPage::class,
            ReportDetailPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::UPDATE);
    }

    public function save(DataWrapperContract $item, ?FieldsContract $fields = null): DataWrapperContract
    {
        $report = $item->getOriginal();

        if ($report instanceof Report && $report->exists) {
            return $item;
        }

        app(ReportService::class)->create(
            new CreateReportDto(
                from: Carbon::parse(request()->input('from')),
                to: Carbon::parse(request()->input('to')),
                type: SailType::from((int) request()->input('type')),
            ),
        );

        return $item;
    }
}
