<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoNews extends Model
{
    protected $fillable = ['title', 'main_thumbnail', 'description', 'status'];

    public function images()
    {
        return $this->hasMany(PhotoNewsImage::class);
    }
}
