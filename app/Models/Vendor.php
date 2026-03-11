<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    protected $collection = "vendor";
    protected $fillable = ['id_vendor','purch_org','nm_vendor','allias','street','district','postal_code','city','country','region','phone_1','vat_reg','order_curr','pay_term','sales_person','phone_2','vend_email','status_vendor'];
    

    public function user()
    {
        return $this->belongsTo(User::class,'id_vendor','foreign_id');
    }
    public function assets()
    {
        return $this->hasMany(\App\Models\masterData\Asset::class, 'vendor_id', 'id_vendor');
    }
    public function riwayatSebagaiStatusAwal()
    {
        return $this->hasMany(\App\Models\masterData\Riwayat::class, 'StatusAwal', '_id');
    }

    public function riwayatSebagaiStatusAkhir()
    {
        return $this->hasMany(\App\Models\masterData\Riwayat::class, 'StatusAkhir', '_id');
    }
    public function maintenances()
    {
        return $this->hasMany(\App\Models\Maintenance::class, 'vendor_id', 'id_vendor');
    }
}