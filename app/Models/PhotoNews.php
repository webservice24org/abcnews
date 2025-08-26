<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class PhotoNews extends Model
{
    protected $fillable = ['title', 'main_thumbnail', 'description', 'status'];

    public function images()
    {
        return $this->hasMany(PhotoNewsImage::class);
    }

    protected static function booted()
    {
        static::saved(function () {
            ResponseCache::clear();
        });

        static::deleted(function () {
            ResponseCache::clear();
        });
    }
}
