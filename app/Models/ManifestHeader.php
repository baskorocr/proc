<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ManifestHeader extends Model
{
   //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "manifest_header";

    protected $fillable = ['manifest','mf_type','release_date','id_vendor','delivery_date','delivery_time','po_num','sent','downloaded','file_nm','stat','active'];
    // type : spc,Mf
    public $dates = ['deleted_at','release_date','delivery_date','delivery_time'];


    public function manifestDetails()
    {
        return $this->hasMany(ManifestDetail::class,'manifest','manifest');
    }

  

    public function vendors()
    {
        return $this->belongsTo(Vendor::class,'id_vendor','id_vendor');
    }
    
   
}

    