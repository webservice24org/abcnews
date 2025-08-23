<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSettings extends Model
{
    protected $fillable = ['key', 'value'];
    public $timestamps = false;

    public static function get(string $key, $default = null)
    {
        return optional(static::where('key', $key)->first())->value ?? $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
