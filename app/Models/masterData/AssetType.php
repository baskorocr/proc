<?php

namespace App\Models\masterData;

use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetType extends Model
{
    use HasFactory;
    protected $collection = 'asset_types';

    protected $fillable = ['name_type'];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}