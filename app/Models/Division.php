<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'name',
    ];

    public function districts() { return $this->hasMany(District::class); }
public function newsPosts() { return $this->hasMany(NewsPost::class); }

}
