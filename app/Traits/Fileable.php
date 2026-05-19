<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait Fileable
{
    /**
     * @param  array<mixed>  $files
     */
    public function addMultiple(array $files): void
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                if ($file->isValid()) {
                    $paths[] = $file->store('', 'public');
                }

                continue;
            }

            if (is_string($file)) {
                if ($file !== '') {
                    $paths[] = $file;
                }
            }
        }

        $this->files = $paths;
    }
}
