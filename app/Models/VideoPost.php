<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_title',
        'video_description',
        'video_link',
        'thumbnail',
        'status',
    ];
}
