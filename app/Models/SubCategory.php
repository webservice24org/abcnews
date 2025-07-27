<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $fillable = ['category_id', 'name', 'slug'];

    protected static function booted()
    {
        static::creating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $subCategory->slug = Str::slug($subCategory->name);
            }
        });

        static::updating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $subCategory->slug = Str::slug($subCategory->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function newsPosts()
    {
        return $this->belongsToMany(
            NewsPost::class,
            'subcategory_news_post',
            'subcategory_id', // foreign key on pivot table for SubCategory
            'news_post_id'    // foreign key on pivot table for NewsPost
        );
    }

}
