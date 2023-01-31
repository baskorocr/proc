<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ProjectVendorAssign extends Model
{   
 
    // END Connect
    protected $table = "proj_vendor_assign";


    public $dates = ['modify_date'];

   

}

    