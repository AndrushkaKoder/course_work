<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait HasPreview
{
    public function addPreview(UploadedFile $preview): void
    {
        if ($preview->isValid()) {
            $this->preview = $preview->store('', 'public');
        }
    }
}
