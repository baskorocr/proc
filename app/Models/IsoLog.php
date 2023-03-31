<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class IsoLog extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "trn_iso_log";

    protected $fillable = [
       'trn_id', 'doc_year', 'id_user', 'trn_type', 'trn_date', 'trn_time', 'ip_address', 'trn_detail'
    ];

    public $dates = [];

}
