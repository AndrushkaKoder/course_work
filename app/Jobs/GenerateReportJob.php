<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\Report\ReportStatus;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

final class GenerateReportJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 300;

    public function __construct(
        public Report $report,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(ReportService $reportService): void
    {
        $reportService->generate($this->report);
    }

    public function failed(?Throwable $exception): void
    {
        $this->report->refresh();

        if ($this->report->status !== ReportStatus::COMPLETED) {
            $this->report->update([
                'status' => ReportStatus::FAILED,
            ]);
        }
    }
}
