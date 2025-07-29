<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialConnection extends Model
{
    protected $fillable = [
        'facebook',
        'twitter',
        'pinterest',
        'tiktok',
        'instagram',
        'youtube',
    ];
}
