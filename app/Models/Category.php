<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\News\Post;
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

    protected static function booted()
    {
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function newsPosts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            'category_news_post',
            'category_id',
            'news_post_id'
        );
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function advertisements(): BelongsToMany
    {
        return $this->belongsToMany(
            Advertisement::class,
            'advertisement_category',
            'category_id',
            'advertisement_id'
        );
    }
}

