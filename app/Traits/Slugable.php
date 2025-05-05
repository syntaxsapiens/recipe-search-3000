<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Slugable
{
    public static function bootSlugable(): void
    {
        static::creating(function ($model) {
            $model->slug = $model->generateUniqueSlug($model->title);
        });
    }

    protected function generateUniqueSlug($title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$count++;
        }

        return $slug;
    }
}
