<?php

namespace App\Models\masterData;

use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Proses extends Model
{
    use HasFactory;
    protected $collection = 'proses';

    protected $fillable = ['proses_name'];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'proses_id', '_id');
    }
}