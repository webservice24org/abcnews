<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Str;

class Upazila extends Model
{
    use HasFactory;

    protected $fillable = ['district_id', 'name', 'slug'];

    protected static function booted()
    {
        static::creating(function ($upazila) {
            if (empty($upazila->slug)) {
                $upazila->slug = Str::slug($upazila->name);
            } else {
                $upazila->slug = Str::slug($upazila->slug);
            }
        });

        static::updating(function ($upazila) {
            if (empty($upazila->slug)) {
                $upazila->slug = Str::slug($upazila->name);
            } else {
                $upazila->slug = Str::slug($upazila->slug);
            }
        });
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function newsPosts()
    {
        return $this->hasMany(Post::class);
    }

    public function slugConfig(): array
    {
        return [
            'source' => 'name',
            'slug'   => 'slug',
        ];
    }
    
}
