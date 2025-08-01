<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_name', 'ad_image', 'ad_code', 'is_global', 'status',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'advertisement_category');
    }

    public function subcategories()
    {
        return $this->belongsToMany(SubCategory::class, 'advertisement_sub_category');
    }
}
