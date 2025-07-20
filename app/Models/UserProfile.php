<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'profile_photo', 'address', 'about', 'dob', 'nid_number', 'mobile_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

