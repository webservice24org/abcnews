<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    protected $fillable = ['site_name', 'tagline', 'meta_tags', 'meta_description', 'site_image', 'copyright_info'];
}
