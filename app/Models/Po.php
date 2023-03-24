<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Po extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "po_list";

    public $dates = ['deleted_at','sent','doc_date','downloaded','accepted','revdt','revtm','aprvdt','aprvtm'];
}
