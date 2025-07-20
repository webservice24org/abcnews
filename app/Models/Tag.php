<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    
    public function newsPosts()
    {
        return $this->belongsToMany(NewsPost::class, 'news_post_tag');
    }
}
