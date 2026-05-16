<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait Fileable
{
    /**
     * @param UploadedFile $preview
     * @return void
     */
    public function addPreview(UploadedFile $preview): void
    {
        if ($preview->isValid()) {
            $this->preview = $preview->store('', 'public');
        }
    }

    /**
     * @param array<UploadedFile> $files
     * @return void
     */
    public function addMultiple(array $files): void
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $paths[] = $file->store('', 'public');
            } elseif (is_string($file) && $file !== '') {
                $paths[] = $file;
            }
        }

        $this->files = $paths;
    }
}
