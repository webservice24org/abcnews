<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\News\Post;
use App\Models\Division;
use App\Models\Upazila;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['division_id', 'name', 'slug'];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function upazilas(): HasMany
    {
        return $this->hasMany(Upazila::class);
    }

    public function newsPosts(): HasMany
    {
        return $this->hasMany(
            Post::class,
            'district_id',  // foreign key in news_posts table
            'id'            // local key in districts table
        );
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
