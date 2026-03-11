<?php

namespace App\Models\masterData;


use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemilik extends Model
{
    use HasFactory;
    protected $collection = 'pemiliks';

    protected $fillable = ['name_pemilik'];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'pemiliks_id', 'id');
    }
}