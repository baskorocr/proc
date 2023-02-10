<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class EmailListGroup extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "mail_mgt";

    protected $fillable = ['mail','abrev','dept_code','name','cr_by','cr_date','ch_by','ch_date'];

    public $dates = ['cr_date','ch_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'cr_by','id_user');
    }
}
