<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class EmailGroup extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "dept_master";

    protected $fillable = ['dept_code','abrev','dept_desc','last_changed_by','last_changed','status_active','ch_by','ch_date'];

    public $dates = ['last_changed','ch_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'last_changed_by','id_user');
    }
}
