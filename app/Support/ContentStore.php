<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ContentStore
{
    /**
     * Read a JSON file from storage/app/content/ directory.
     * Returns an array with the parsed JSON content.
     */
    public static function readJson(string $filename): array
    {
        $path = "content/{$filename}.json";

        if (!Storage::exists($path)) {
            return [];
        }

        $content = Storage::get($path);

        return json_decode($content, true) ?? [];
    }

    /**
     * Write a JSON file to storage/app/content/ directory.
     */
    public static function writeJson(string $filename, array $data): void
    {
        $path = "content/{$filename}.json";
        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
