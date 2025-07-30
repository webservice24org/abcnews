<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['header_logo', 'footer_logo', 'print_logo', 'favicon'];
}
