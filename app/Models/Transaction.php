<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Transaction extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "transaction_type";

  

    public $dates = ['ch_date', 'cr_date'];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'id_vendor','id_vendor'); 
    }
}
