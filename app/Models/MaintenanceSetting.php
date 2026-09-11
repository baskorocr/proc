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

    public static function getIntervalByMovingType($movingType)
    {
        $intervals = [
            'slow_moving' => static::getValue('interval_slow_moving', 6),
            'standar_moving' => static::getValue('interval_standar_moving', 3),
            'fast_moving' => static::getValue('interval_fast_moving', 1),
        ];

        return $intervals[$movingType] ?? $intervals['standar_moving'];
    }
}
