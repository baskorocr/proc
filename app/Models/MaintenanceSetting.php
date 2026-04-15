<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class MaintenanceSetting extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'maintenance_settings';

    protected $fillable = ['key', 'value'];

    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? (int) $setting->value : $default;
    }
}
