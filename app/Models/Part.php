<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Part extends Model
{
    // END Connect
    protected $table = "part";

    protected $fillable = ['id_part','part_num','nm_part','modify_date','id_user','status','assigned'];

    public $dates = ['modify_date'];
    
    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }

    public function partForProduct()
    {
        return $this->belongsTo(PartForProduct::class,'id_part','id_part');
    }
}

    