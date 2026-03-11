<?php

namespace App\Models\masterData;

use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Vendor;

use App\Models\User;
class Riwayat extends Model
{
    use HasFactory;
    protected $collection = 'riwayats';
    protected $fillable = ['no_assets', 'idUser', 'StatusAwal', 'StatusAkhir', 'bukti', 'TanggalPemindahan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
    public function statusAwalVendor()
    {
        return $this->belongsTo(Vendor::class, 'StatusAwal', 'id_vendor');
    }

    public function statusAkhirVendor()
    {
        return $this->belongsTo(Vendor::class, 'StatusAkhir', 'id_vendor');
    }
}