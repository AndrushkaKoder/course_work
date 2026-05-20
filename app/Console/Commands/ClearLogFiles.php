<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('logs:clear')]
class ClearLogFiles extends Command
{
    protected $description = 'Удалить файлы логов из storage/logs';

    public function handle(): int
    {
        $logDirectory = storage_path('logs');
        $deletedCount = 0;

        foreach (File::glob($logDirectory.'/*.log') ?: [] as $logFile) {
            if (File::delete($logFile)) {
                $deletedCount++;
            }
        }

        $this->info("Удалено файлов: {$deletedCount}");

        return self::SUCCESS;
    }
}
