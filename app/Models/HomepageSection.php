<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class HomepageSection extends Model
{
    protected $fillable = ['title','component','category_id','order','status'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
