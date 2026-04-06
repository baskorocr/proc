<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\masterData\Asset;
use App\Models\Vendor;

class RescheduleLog extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'reschedule_logs';

    protected $fillable = [
        'asset_id',
        'vendor_id',
        'user_id',
        'user_name',
        'old_date',
        'new_date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'no_assets');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id_vendor');
    }
}
