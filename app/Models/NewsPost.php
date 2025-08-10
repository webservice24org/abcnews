<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use WireComments\Traits\Commentable;
use App\Models\{
    Category, SubCategory, Tag, Division, District, Upazila, User
};

class NewsPost extends Model
{
    use SoftDeletes;
     use Commentable;

    protected $fillable = [
        'news_title',
        'top_title',
        'slug',
        'news_description',
        'division_id',
        'district_id',
        'upazila_id',
        'user_id',
        'news_thumbnail',
        'meta_title',
        'meta_description',
        'is_premium',
        'is_lead',
        'is_sub_lead',
        'status',         
        'scheduled_at',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_lead' => 'boolean',
        'is_sub_lead' => 'boolean',
        'scheduled_at' => 'datetime',
    ];

     protected $dates = ['deleted_at'];

    // Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_news_post');
    }

    public function subcategories()
    {
        return $this->belongsToMany(SubCategory::class, 'subcategory_news_post', 'news_post_id', 'subcategory_id');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_post_tag');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Status helpers
    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isScheduled()
    {
        return $this->status === 'scheduled' && $this->scheduled_at?->isFuture();
    }

    // Query scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')->where('scheduled_at', '>', now());
    }
}

