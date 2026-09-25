<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Portfolio;
use App\Support\ImageOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * One-off: convert already-uploaded portfolio and blog images to resized
 * WebP and point each database row at the new file. Originals are kept
 * unless --delete-originals is given.
 */
class OptimizeImages extends Command
{
    protected $signature = 'images:optimize
                            {--dry-run : Only list what would be converted}
                            {--delete-originals : Remove the original JPG/PNG after a successful conversion}';

    protected $description = 'Convert uploaded portfolio/blog images to WebP (max 1600px wide) and update the database';

    public function handle(): int
    {
        if (! ImageOptimizer::isAvailable()) {
            $this->error('PHP GD with WebP support is not available on this server.');

            return self::FAILURE;
        }

        $disk = Storage::disk('public');
        $dryRun = (bool) $this->option('dry-run');
        $before = $after = $converted = 0;

        foreach ([Portfolio::class, Blog::class] as $model) {
            foreach ($model::query()->whereNotNull('image')->get() as $row) {
                $path = $row->image;

                if (! preg_match('/\.(jpe?g|png)$/i', $path)) {
                    continue;
                }
                if (! $disk->exists($path)) {
                    $this->warn("Missing file, skipped: {$path}");

                    continue;
                }

                $size = $disk->size($path);

                if ($dryRun) {
                    $this->line(sprintf('Would convert %s (%s KB)', $path, number_format($size / 1024)));

                    continue;
                }

                $newPath = ImageOptimizer::toWebp($path, 'public', (bool) $this->option('delete-originals'));
                if ($newPath === $path) {
                    $this->warn("Could not convert, left as is: {$path}");

                    continue;
                }

                $row->image = $newPath;
                $row->save();

                $newSize = $disk->size($newPath);
                $before += $size;
                $after += $newSize;
                $converted++;
                $this->info(sprintf('%s → %s (%s KB → %s KB)', $path, $newPath, number_format($size / 1024), number_format($newSize / 1024)));
            }
        }

        if (! $dryRun) {
            $this->newLine();
            $this->info(sprintf('Converted %d image(s): %s KB → %s KB.', $converted, number_format($before / 1024), number_format($after / 1024)));
        }

        return self::SUCCESS;
    }
}
