<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteConnection extends Model
{
    protected $fillable = [
        'google_verification',
        'bing_verification', 
        'baidu_verification', 
        'pinterest_verification', 
        'yandex_verification'
    ];
}
