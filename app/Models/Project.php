<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;


class Project extends Model
{

    protected $table = "project";

    protected $fillable = ['id_project','proj_num','nm_project','modify_date','id_user','status','assigned'];

    public $dates = ['modify_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }
    
   
}

    