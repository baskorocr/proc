<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;


class ProjectDocAssign extends Model
{

    protected $table = "proj_doc_assign";

    protected $fillable = ['id_assign','id_product','id_part','id_doc_part','check_params','comment','check_status','checker_id','check_date'];

    public $dates = ['check_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }
    
   
}

    