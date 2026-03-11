<?php

namespace App\Models\masterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'vendors';
    protected $fillable = ['name_vendor'];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'vendor_id', 'id');
    }
}