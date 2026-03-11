<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\masterData\Asset;
use App\Models\User;


class scheduleKunjungan extends Model
{
    use HasFactory;
    protected $connection = 'mongodb'; 
    protected $collection = 'schedule_kunjungans';
    
    protected $fillable = [
        'asset_id',
        'idUser',
        'waktu_kunjungan',
    ];

    protected $casts = [
        'waktu_kunjungan' => 'datetime',
    ];

    // Relasi ke Asset (koleksi MongoDB)
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'no_assets');
    }

    // Relasi ke User (juga koleksi MongoDB)
    public function user()
    {
        return $this->belongsTo(MasterUser::class, 'idUser', '_id');
    }

}