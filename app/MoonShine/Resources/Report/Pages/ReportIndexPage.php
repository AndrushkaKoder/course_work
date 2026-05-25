<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Report\Pages;

use App\Enums\Report\ReportStatus;
use App\Models\Report;
use App\MoonShine\Resources\Report\ReportResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<ReportResource>
 */
final class ReportIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Тип сделки', 'type', fn (Report $report): string => $report->formattedType()),
            Text::make('Период', 'from', fn (Report $report): string => $report->formattedPeriod()),
            Text::make('Статус', 'status', fn (Report $report): string => $report->status->formattedValue())
                ->badge(function (mixed $value, Text $field): string {
                    $report = $field->getData()->getOriginal();

                    if (! $report instanceof Report) {
                        return 'gray';
                    }

                    return match ($report->status) {
                        ReportStatus::PENDING => 'gray',
                        ReportStatus::PROCESSING => 'warning',
                        ReportStatus::COMPLETED => 'success',
                        ReportStatus::FAILED => 'error',
                    };
                }),
            File::make('Отчет', 'file'),
            Text::make('Автор', 'user.name'),
            Date::make('Создан', 'created_at'),
        ];
    }
}
