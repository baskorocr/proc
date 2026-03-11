<?php

namespace App\Models\masterData;

use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPart';
    public $incrementing = false;

    protected $fillable = [
        'idPart',
        'part_name',
        'spek_material',
        'photo',


    ];
}