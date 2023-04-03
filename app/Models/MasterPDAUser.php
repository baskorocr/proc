<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class MasterPDAUser extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "pda_access";

    protected $fillable = ['id','username','full_name','user_stat'];

    public $dates = ['cr_date','ch_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'cr_by','id_user');
    }
}