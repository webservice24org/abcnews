<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoNewsImage extends Model
{
    protected $fillable = ['photo_news_id', 'image', 'caption'];

    public function photoNews()
    {
        return $this->belongsTo(PhotoNews::class);
    }
}
