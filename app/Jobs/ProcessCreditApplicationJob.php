<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\CreditApplication\CreditApplicationStatus;
use App\Models\CreditApplication;
use App\MoonShine\Resources\CreditApplication\CreditApplicationResource;
use App\Support\CreditApplicationCancelReasons;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use MoonShine\Crud\Notifications\NotificationButton;
use MoonShine\Laravel\Notifications\MoonShineNotification;
use MoonShine\Support\Enums\Color;

final class ProcessCreditApplicationJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 120;

    public function __construct(
        public CreditApplication $application,
    ) {}

    public function handle(): void
    {
        $application = $this->application->refresh();

        if ($application->status !== null) {
            return;
        }

        sleep(random_int(30, 60));

        $status = CreditApplicationStatus::randomBankResult();

        $application->status = $status;
        $application->cancel_reason = $status === CreditApplicationStatus::FAILED
            ? CreditApplicationCancelReasons::random()
            : null;
        $application->save();

        $this->notifyAdministrators($application, $status);
    }

    private function notifyAdministrators(CreditApplication $application, CreditApplicationStatus $status): void
    {
        if ($application->user_id === null) {
            return;
        }

        $resource = app(CreditApplicationResource::class);

        $message = sprintf(
            'Заявка на кредит #%d обработана: %s',
            $application->id,
            $status->formattedValue(),
        );

        if ($status === CreditApplicationStatus::FAILED && $application->cancel_reason !== null) {
            $message .= sprintf(' (%s)', $application->cancel_reason);
        }

        MoonShineNotification::send(
            message: $message,
            button: new NotificationButton(
                'Открыть заявку',
                $resource->getDetailPageUrl($application->id),
            ),
            ids: [$application->user_id],
            color: $status === CreditApplicationStatus::SUCCESS ? Color::GREEN : Color::ERROR,
            icon: $status === CreditApplicationStatus::SUCCESS ? 'check-circle' : 'x-circle',
        );
    }
}
