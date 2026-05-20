<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use App\Support\MoonShine\DefaultManagerPermissions;
use Illuminate\Database\Seeder;

final class UserPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::query()
            ->where('user_role_id', UserRole::MANAGER_ID)
            ->where('email', 'manager@mail.com')
            ->first();

        if ($manager === null) {
            return;
        }

        UserPermission::query()->updateOrCreate(
            ['user_id' => $manager->id],
            ['permissions' => DefaultManagerPermissions::toPermissionsArray()],
        );
    }
}
