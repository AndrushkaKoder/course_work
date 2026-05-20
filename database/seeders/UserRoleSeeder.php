<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_roles')->upsert([
            [
                'id' => UserRole::ADMIN_ID,
                'name' => 'Администратор',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => UserRole::MANAGER_ID,
                'name' => 'Менеджер',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['id'], ['name', 'updated_at']);

        DB::table('users')
            ->whereNull('user_role_id')
            ->update(['user_role_id' => UserRole::ADMIN_ID]);
    }
}
