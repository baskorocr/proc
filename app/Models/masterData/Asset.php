<?php

namespace App\Models\masterData;

use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Vendor;
use App\Models\scheduleKunjungan;
use App\Models\MasterUser;
use App\Models\Maintenance;
use App\Models\masterData\Project;
use App\Models\masterData\AssetType;
use App\Models\masterData\Pemilik;
use App\Models\masterData\Part;
use App\Models\masterData\Proses;



class Asset extends Model
{
   

    use HasFactory;
    protected $connection = 'mongodb';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $collection = 'assets';

    protected $fillable = [
        'no_assets',
        'vendor_id',
        'project_id',
        'asset_type_id',
        'pemiliks_id',
        'idUser',
        'idPart',
         'dies',
        'proses_id',
       'Cavity',
        'machine',
        'jumlah'
    ];

 
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id_vendor');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', '_id');
    }

    public function assetType()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id', '_id');
    }

    public function proses()
    {
        return $this->belongsTo(Proses::class, 'proses_id', '_id');
    }

    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'pemiliks_id', '_id');
    }

    // Asset.php (Model)
  

    public function part()
    {
        return $this->belongsTo(Part::class, 'idPart', 'idPart');
    }

    public function user()
    {
        return $this->belongsTo(MasterUser::class, 'idUser', 'id_user');
    }
    public function scheduleKunjungans()
    {
        return $this->hasOne(ScheduleKunjungan::class, 'asset_id', 'no_assets')->latest('_id');
    }
public function maintenances()
{
    return $this->hasMany(Maintenance::class, 'asset_no', 'no_assets');
}


}