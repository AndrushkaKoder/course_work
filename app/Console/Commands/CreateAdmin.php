<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('admin:create')]
class CreateAdmin extends Command
{
    protected $description = 'Создать администратора в таблице users';

    public function handle(): int
    {
        return $this->call('moonshine:user');
    }
}
