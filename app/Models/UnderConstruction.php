<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnderConstruction extends Model
{
    use HasFactory;

    // Specify the table name (optional if Laravel naming matches)
    protected $table = 'under_construction';

    // Fillable fields for mass assignment
    protected $fillable = [
        'banner_text',
        'start_time',
        'end_time',
        'status',
    ];

    // Cast start_time and end_time to Carbon instances
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'boolean',
    ];
}
