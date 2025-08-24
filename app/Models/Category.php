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
        'name',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Single booted method: handle slug generation and cascade status change.
     */
    protected static function booted()
    {
        // auto-generate slug on saving (create or update)
        static::saving(function ($category) {
            if (empty($category->slug) && ! empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // cascade status change to subcategories when status field changed
        static::updated(function ($category) {
            if ($category->isDirty('status')) {
                // Use the actual relation name below (subcategories)
                $category->subcategories()->update(['status' => $category->status]);
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