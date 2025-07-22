<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Str;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['division_id', 'name', 'slug'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function upazilas()
    {
        return $this->hasMany(Upazila::class);
    }

    public function newsPosts()
    {
        return $this->hasMany(NewsPost::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($district) {
            if (empty($district->slug)) {
                $district->slug = Str::slug($district->name);
            }
        });

        static::updating(function ($district) {
            if (empty($district->slug)) {
                $district->slug = Str::slug($district->name);
            }
        });
    }

    public function slugConfig(): array
    {
        return [
            'source' => 'name',
            'slug'   => 'slug',
        ];
    }
    
}
