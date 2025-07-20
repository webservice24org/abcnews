<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function newsPosts()
    {
        return $this->belongsToMany(NewsPost::class, 'category_news_post');
    }

    /* If you keep a hasMany relation to sub‑categories */
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
