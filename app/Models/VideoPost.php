<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class VideoPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_title',
        'video_description',
        'video_link',
        'thumbnail',
        'status',
    ];

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
