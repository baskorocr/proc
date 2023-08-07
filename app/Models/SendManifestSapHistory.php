<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class SendManifestSapHistory extends Model
{
   //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "send_manifest_sap_histories";

    protected $guarded = [];


    
   
}

    