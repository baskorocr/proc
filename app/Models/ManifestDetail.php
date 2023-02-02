<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ManifestDetail extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "manifest_detail";

    protected $fillable = ['kanban','seq_kanban','manifest','item','material','material_desc','qty_pack','qty_in','arrival_date','arrival_time','scan_by','issued_date','issued_time','active'];
    // type : spc,Mf
    public $dates = ['deleted_at','arrival_date','arrival_time'];
    
   
    public function manifestHeaders()
    {
        return $this->belongsTo(ManifestHeader::class,'manifest','manifest');
    }
}

    