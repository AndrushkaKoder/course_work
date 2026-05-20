<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() > 0) {
            $this->command->error('Users already exists.');

            return;
        }

        foreach ($this->getUsers() as $user) {
            User::create($user);
        }

        $this->command->info('Users added.');
    }

    private function getUsers(): array
    {
        return [
            [
                'name' => 'manager',
                'email' => 'manager@mail.com',
                'password' => \Hash::make('1234567890Aa+'),
                'user_role_id' => UserRole::MANAGER_ID,
            ],
            [
                'name' => 'administrator',
                'email' => 'admin@mail.com',
                'password' => \Hash::make('1234567890Aa+'),
                'user_role_id' => UserRole::query()->where('name', 'Администратор')->first()->id,
            ],
        ];
    }
}
