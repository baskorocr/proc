<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class PartForProduct extends Model
{   
 
    // END Connect
    protected $table = "part_for_product";

    protected $fillable = ['id_assign','id_product','id_part','modify_date','id_user'];

    public $dates = ['modify_date'];

   
    public function product()
    {
        return $this->belongsTo(Product::class,'id_product','id_product');
    }

    public function part()
    {
        return $this->belongsTo(Part::class,'id_part','id_part');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }

}

    