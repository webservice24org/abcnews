<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageLeadSection extends Model
{
    protected $fillable = [
        'enabled',
        'design',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
