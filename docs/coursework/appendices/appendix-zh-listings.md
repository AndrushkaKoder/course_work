# Приложение Ж. Листинги программных модулей

## Ж.1 Синхронизация статуса автомобиля при сделке продажи

Файл: `app/Services/SailService.php` (фрагмент)

```php
private function syncSellCarStatus(Sail $sail, ?SailStatus $sailStatus): void
{
    if ($this->resolveType($sail->type) !== SailType::SELL) {
        return;
    }

    if ($sail->car_id === null) {
        return;
    }

    $carStatus = match ($sailStatus) {
        SailStatus::PENDING => CarStatus::RESERVED,
        SailStatus::COMPLETED => CarStatus::SOLD,
        SailStatus::CANCELLED => CarStatus::IN_STOCK,
        default => null,
    };

    if ($carStatus === null) {
        return;
    }

    $this->carService->updateCarStatus((int) $sail->car_id, $carStatus);
}
```

## Ж.2 Миграция таблицы сделок

Файл: `database/migrations/2026_04_26_092149_create_sails_table.php`

```php
Schema::create('sails', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('client_id')->nullable();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->unsignedBigInteger('car_id')->nullable();
    $table->integer('price')->nullable();
    $table->enum('status', SailStatus::cases())->default(SailStatus::PENDING);
    $table->enum('type', SailType::cases());
    $table->timestamps();

    $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null');
});
```

## Ж.3 Постановка отчёта в очередь

Файл: `app/Services/ReportService.php` (фрагмент)

```php
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
```

## Ж.4 Меню административной панели

Файл: `app/MoonShine/Layouts/MoonShineLayout.php` (фрагмент метода `menu`)

```php
MenuGroup::make('Сделки', [
    MenuItem::make(SailSellResource::class, 'Продажа')
        ->canSee(static fn (): bool => MenuAuthorization::can(SailSellResource::class)),
    MenuItem::make(SailBuyResource::class, 'Покупка')
        ->canSee(static fn (): bool => MenuAuthorization::can(SailBuyResource::class)),
]),
```

Полные исходные тексты — в репозитории проекта `course_work`.
