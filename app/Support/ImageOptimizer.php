<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Shrinks uploaded images and converts them to WebP using PHP's built-in GD
 * extension (no extra package). Any failure falls back to the original file,
 * so an upload is never lost because optimization didn't work.
 */
class ImageOptimizer
{
    public const MAX_WIDTH = 1600;

    public const QUALITY = 80;

    public static function isAvailable(): bool
    {
        return function_exists('imagewebp') && function_exists('imagecreatefromstring');
    }

    /**
     * Convert $path (relative to the disk) to a resized .webp next to it.
     *
     * Returns the new relative path, or the original $path if nothing was
     * done (GD missing, unsupported format, already WebP, or an error).
     * With $deleteOriginal the source file is removed after a successful
     * conversion.
     */
    public static function toWebp(string $path, string $disk = 'public', bool $deleteOriginal = true): string
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (! self::isAvailable() || ! in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
            return $path;
        }

        $storage = Storage::disk($disk);
        $newPath = preg_replace('/\.[^.]+$/', '.webp', $path);

        try {
            $source = @imagecreatefromstring($storage->get($path));
            if ($source === false) {
                return $path;
            }

            $width = imagesx($source);
            $height = imagesy($source);

            if ($width > self::MAX_WIDTH) {
                $newHeight = (int) round($height * self::MAX_WIDTH / $width);
                $resized = imagecreatetruecolor(self::MAX_WIDTH, $newHeight);
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, self::MAX_WIDTH, $newHeight, $width, $height);
                $source = $resized;
            } else {
                // Palette PNGs can't be written as WebP directly.
                imagepalettetotruecolor($source);
                imagealphablending($source, false);
                imagesavealpha($source, true);
            }

            ob_start();
            $ok = imagewebp($source, null, self::QUALITY);
            $webp = ob_get_clean();

            if (! $ok || $webp === '' || $webp === false) {
                return $path;
            }

            $storage->put($newPath, $webp);
        } catch (Throwable $e) {
            report($e);

            return $path;
        }

        if ($deleteOriginal && $newPath !== $path) {
            $storage->delete($path);
        }

        return $newPath;
    }
}
