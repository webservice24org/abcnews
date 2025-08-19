<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Division extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($division) {
            if (empty($division->slug)) {
                $division->slug = Str::slug($division->name);
            }
        });

        static::updating(function ($division) {
            if (empty($division->slug)) {
                $division->slug = Str::slug($division->name);
            }
        });
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function newsPosts()
    {
        return $this->hasMany(Post::class);
    }

    

}

