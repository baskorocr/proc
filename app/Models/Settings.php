<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $dates = [
        'deleted_at'
    ];

    protected $casts = [
        'value' => 'array',
    ];

    public function scopeGetValue($query, $config)
    {
        $data = $query->where('variable', $config)->first();
        return $data->value;

    }
}
