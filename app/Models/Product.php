<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    // END Connect
    protected $table = "product";

    protected $fillable = ['id_product','prod_num','nm_product','modify_date','id_user','status','assigned'];

    public $dates = ['modify_date'];
    
    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }

}

    