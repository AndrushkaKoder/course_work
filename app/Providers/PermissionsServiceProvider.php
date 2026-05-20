<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Подключает moonshine/permissions без миграций пакета (таблица user_permissions — в проекте).
 */
final class PermissionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $basePath = base_path('vendor/moonshine/permissions');

        $this->loadRoutesFrom($basePath.'/routes/permissions.php');
        $this->loadViewsFrom($basePath.'/resources/views', 'moonshine-permissions');
        $this->loadTranslationsFrom($basePath.'/lang', 'moonshine-permissions');
    }
}
