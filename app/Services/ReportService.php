<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateReportDto;
use App\Enums\Report\ReportStatus;
use App\Enums\Sail\SailStatus;
use App\Enums\Sail\SailType;
use App\Jobs\GenerateReportJob;
use App\Models\Report;
use App\Models\Sail;
use App\Support\MoneyFormat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\MoonShineAuth;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Writer\Exception\WriterNotOpenedException;
use OpenSpout\Writer\XLSX\Writer;
use Throwable;

final readonly class ReportService
{
    public function create(CreateReportDto $dto): Report
    {
        $report = Report::query()->create([
            'user_id' => MoonShineAuth::getGuard()->id(),
            'from' => $dto->from->toDateString(),
            'to' => $dto->to->toDateString(),
            'type' => $dto->type,
            'status' => ReportStatus::PENDING,
        ]);

        GenerateReportJob::dispatch($report);

        return $report;
    }

    public function generate(Report $report): void
    {
        $report->update(['status' => ReportStatus::PROCESSING]);

        try {
            $sails = $this->fetchCompletedSails($report);
            $filePath = $this->buildSpreadsheet($report, $sails);

            $report->update([
                'status' => ReportStatus::COMPLETED,
                'file' => $filePath,
            ]);
        } catch (Throwable $exception) {
            $report->update(['status' => ReportStatus::FAILED]);

            throw $exception;
        }
    }

    /**
     * @return Collection<int, Sail>
     */
    private function fetchCompletedSails(Report $report): Collection
    {
        return Sail::query()
            ->with(['car', 'client', 'user'])
            ->where('status', SailStatus::COMPLETED)
            ->where('type', $report->type)
            ->whereBetween('created_at', [
                Carbon::parse($report->from)->startOfDay(),
                Carbon::parse($report->to)->endOfDay(),
            ])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * @throws IOException
     * @throws WriterNotOpenedException
     */
    private function buildSpreadsheet(Report $report, Collection $sails): string
    {
        $directory = 'reports';
        Storage::disk('public')->makeDirectory($directory);

        $relativePath = sprintf(
            '%s/%s_%d_%s.xlsx',
            $directory,
            strtolower($report->type->name),
            $report->id,
            now()->format('Ymd_His'),
        );

        $absolutePath = Storage::disk('public')->path($relativePath);

        $writer = new Writer;
        $writer->openToFile($absolutePath);

        $dateColumn = $report->type === SailType::SELL ? 'Дата продажи' : 'Дата покупки';

        $writer->addRow(Row::fromValues([
            '№',
            $dateColumn,
            'Автомобиль',
            'VIN',
            'Сумма',
            'Клиент',
            'Менеджер',
        ]));

        $totalPrice = 0;

        foreach ($sails as $index => $sail) {
            $totalPrice += (int) $sail->price;

            $writer->addRow(Row::fromValues([
                $index + 1,
                $sail->created_at?->format('d.m.Y H:i') ?? '',
                $sail->car?->getViewName() ?? 'Удален из базы',
                $sail->car?->vin_code ?? '',
                $sail->formattedPrice(),
                $sail->client !== null ? "{$sail->client->name} ({$sail->client_id})" : '',
                $sail->user !== null ? "{$sail->user->name} ({$sail->user_id})" : '',
            ]));
        }

        $writer->addRow(Row::fromValues([
            'Итого:',
            sprintf('Сделок: %d', $sails->count()),
            '',
            '',
            MoneyFormat::format($totalPrice),
            '',
            '',
        ]));

        $writer->close();

        return $relativePath;
    }
}
