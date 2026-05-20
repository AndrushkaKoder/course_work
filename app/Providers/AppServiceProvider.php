<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\MoonShine\UserPermissionController;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use MoonShine\Permissions\Http\Controllers\PermissionController as PackagePermissionController;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // После moonshine:install --force publish не должен оставлять MoonshineUser в рантайме
        config([
            'moonshine.auth.model' => User::class,
            'auth.providers.moonshine.model' => User::class,
        ]);

        $this->app->bind(PackagePermissionController::class, UserPermissionController::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (str_starts_with((string) config('app.url'), 'https://')) {
            if (app()->isProduction()) {
                URL::forceScheme('https');
            }

        }

        View::addNamespace('pages', resource_path('pages'));
    }
}
