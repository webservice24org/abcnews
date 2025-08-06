<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\NewsPost;
use App\Models\SubCategory;
use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
            'subcategory_id',         
            'news_post_id'            
        );
    }

    
    public function ads()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_sub_category', 'sub_category_id', 'advertisement_id');
    }


}
