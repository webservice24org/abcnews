<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\NewsPost;
use App\Models\SubCategory;
use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // Category.php
    public function advertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_category', 'category_id', 'advertisement_id');
    }


}

