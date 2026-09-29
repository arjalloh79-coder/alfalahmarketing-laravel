<?php

namespace App\Support;

use App\Models\Blog;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

/**
 * One-shot repair of audit items that previously required the admin panel.
 * Runs on boot, never throws, and no-ops after the first successful pass.
 */
class AuditContentFix
{
    public const FLAG = 'audit-content-fixed-v1';

    public static function run(): void
    {
        try {
            if (Cache::get(self::FLAG)) {
                return;
            }
            if (! Schema::hasTable('blogs') && ! Schema::hasTable('portfolios')) {
                return;
            }

            if (Schema::hasTable('blogs')) {
                Blog::query()->each(function (Blog $blog) {
                    $dirty = false;

                    $title = (string) $blog->title;
                    if (preg_match('/The 2026 Growth Blueprint:?\s*$/i', $title)) {
                        $blog->title = 'The 2026 Growth Blueprint: Merging AI, Intent-Driven SEO, and Conversion Design';
                        $dirty = true;
                    }

                    $content = (string) $blog->content;
                    $new = preg_replace('/since 2009/i', 'since 2023', $content) ?? $content;
                    $new = preg_replace(
                        '/^\s*Estimated Reading Time.{0,160}?Abdulrahman Jalloh\.?\s*/is',
                        '',
                        $new
                    ) ?? $new;
                    $new = str_ireplace('EI Maloum', 'El Maloum', $new);
                    if ($new !== $content) {
                        $blog->content = $new;
                        $dirty = true;
                    }

                    if ($dirty) {
                        $blog->save();
                    }
                });
            }

            if (Schema::hasTable('portfolios')) {
                Portfolio::query()->each(function (Portfolio $item) {
                    $dirty = false;
                    $title = (string) $item->title;
                    if (stripos($title, 'EI Maloum') !== false) {
                        $item->title = str_ireplace('EI Maloum', 'El Maloum', $title);
                        $dirty = true;
                    }
                    $url = (string) ($item->project_url ?? '');
                    if (preg_match('/hostingersite\.com|lovable\.app|manus\.space/i', $url)) {
                        $item->project_url = null;
                        $dirty = true;
                    }
                    if ($dirty) {
                        $item->save();
                    }
                });
            }

            Cache::forever(self::FLAG, now()->toIso8601String());
        } catch (Throwable $e) {
            // Never take the site down for a content repair.
        }
    }
}
