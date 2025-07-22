<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug',
    ];

    public static function booted()
    {
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function newsPosts()
    {
        return $this->belongsToMany(NewsPost::class, 'category_news_post');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}

