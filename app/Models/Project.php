<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'cover', 'slug', 'description', 'content', 'images',
    ];

    protected function casts()
    {
        return [
            'images' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = self::createUniqueSlug($model->title);
        });

        static::updating(function ($model) {
            $model->slug = self::createUniqueSlug($model->title, $model->id);
        });
    }

    private static function createUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $count = 2;

        while (self::whereSlug($slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = Str::slug($title) . '-' . $count++;
        }

        return $slug;
    }
}
