<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = ['title', 'slug', 'category', 'author', 'image', 'content', 'read_time', 'is_featured'];

    // Automatically create slug from title
    protected static function boot() {
        parent::boot();
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }

    /**
     * Plain-text body with HTML stripped and the duplicated
     * "Estimated Reading Time... by Abdulrahman Jalloh" byline (present at
     * the start of some posts) removed, so excerpts don't start with it.
     */
    public function getCleanExcerptAttribute(): string
    {
        $text = strip_tags($this->content);
        $text = preg_replace('/^\s*Estimated Reading Time.{0,100}?Abdulrahman Jalloh\.?\s*/is', '', $text);

        return trim($text);
    }

    public function excerpt(int $length = 155): string
    {
        return Str::limit($this->clean_excerpt, $length);
    }
}