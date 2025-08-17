<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'news_post_id',
        'sent_at',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function news()
    {
        return $this->belongsTo(NewsPost::class, 'news_id');
    }
}
