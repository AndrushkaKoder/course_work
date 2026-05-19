<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Throwable;

trait Fileable
{
    /**
     * @param array<mixed> $files
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

    /**
     * @param  array<string>  $urls
     */
    public function addMultipleFromUrl(array $urls): void
    {
        $files = [];

        foreach ($urls as $url) {
            if (! is_string($url) || $url === '') {
                continue;
            }

            $uploadedFile = $this->createUploadedFileFromUrl($url);

            if ($uploadedFile !== null) {
                $files[] = $uploadedFile;
            }
        }

        if ($files !== []) {
            $this->addMultiple($files);
        }
    }

    private function createUploadedFileFromUrl(string $url): ?UploadedFile
    {
        try {
            $response = Http::timeout(30)->get($url);

            if (! $response->successful()) {
                return null;
            }

            $tempPath = tempnam(sys_get_temp_dir(), 'url_file_');

            if ($tempPath === false) {
                return null;
            }

            file_put_contents($tempPath, $response->body());

            $contentType = $response->header('Content-Type');
            $mimeType = $contentType !== null
                ? explode(';', $contentType)[0]
                : mime_content_type($tempPath);

            return new UploadedFile(
                $tempPath,
                $this->filenameFromUrl($url, $contentType),
                is_string($mimeType) ? $mimeType : null,
                UPLOAD_ERR_OK,
                true,
            );
        } catch (Throwable) {
            return null;
        }
    }

    private function filenameFromUrl(string $url, ?string $contentType = null): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $filename = is_string($path) ? basename($path) : '';

        if ($filename !== '' && str_contains($filename, '.')) {
            return $filename;
        }

        $extension = match (true) {
            str_contains((string) $contentType, 'png') => 'png',
            str_contains((string) $contentType, 'gif') => 'gif',
            str_contains((string) $contentType, 'webp') => 'webp',
            default => 'jpg',
        };

        return ($filename !== '' ? $filename : 'image').'.'.$extension;
    }
}
