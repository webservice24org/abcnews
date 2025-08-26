<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class PhotoNewsImage extends Model
{
    protected $fillable = ['photo_news_id', 'image', 'caption'];

    public function photoNews()
    {
        return $this->belongsTo(PhotoNews::class);
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
