<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class DeliverySchedule extends Model
{
    protected $table = "delivery_schedule";

    protected $fillable = ['manifest','delivery_date','type','po_number','vendor','vendor_name','email','file_name'];
    // type : spc,Mf
    public $dates = ['deleted_at'];
    
   
}

    