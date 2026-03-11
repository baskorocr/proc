<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\masterData\Asset;
use App\Models\Vendor;

class Maintenance extends Model
{
    use HasFactory;

    protected $connection = 'mongodb'; // 👈 ini penting kalau pakai MongoDB
    protected $collection = 'maintenances'; // kalau mau explicit

    protected $fillable = [
        'asset_no',
        'vendor_id',
        'nama_file',
        'deskripsi',
        'status'
    ];

    // Relationship with Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_no', 'no_assets');
    }

    // Relationship with Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id_vendor');
    }
}