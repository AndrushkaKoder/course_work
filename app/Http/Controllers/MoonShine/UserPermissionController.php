<?php

declare(strict_types=1);

namespace App\Http\Controllers\MoonShine;

use App\Models\UserPermission;
use Illuminate\Http\RedirectResponse;
use MoonShine\Laravel\Http\Controllers\MoonShineController;
use MoonShine\Permissions\Http\Requests\PermissionFormRequest;
use MoonShine\Support\Enums\ToastType;

final class UserPermissionController extends MoonShineController
{
    public function __invoke(PermissionFormRequest $request): RedirectResponse
    {
        $item = $request->getResource()?->getItem();

        if ($item === null) {
            return back();
        }

        if (! $request->has('permissions')) {
            $item->userPermission()?->delete();
        } else {
            UserPermission::query()->updateOrCreate(
                ['user_id' => $item->getKey()],
                $request->only(['permissions']) + ['user_id' => $item->getKey()],
            );
        }

        $this->toast(
            __('moonshine::ui.saved'),
            ToastType::SUCCESS,
        );

        return back();
    }
}
