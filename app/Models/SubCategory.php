<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

    public function newsPosts()
    {
        return $this->belongsToMany(NewsPost::class, 'subcategory_news_post');
    }
}
