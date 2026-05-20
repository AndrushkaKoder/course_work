<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Horizon::auth(function (Request $request): bool {
            $user = $request->user('moonshine')
                ?? Auth::guard('moonshine')->user()
                ?? $request->user('web')
                ?? $request->user();

            if ($user === null) {
                return false;
            }

            return Gate::forUser($user)->allows('viewHorizon');
        });
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', function (?Authenticatable $user = null): bool {
            if ($user === null || ! isset($user->email)) {
                return false;
            }

            if ($user instanceof User && $user->isSuperUser()) {
                return true;
            }

            return in_array((string) $user->email, config('horizon.admins', []), true);
        });
    }
}
