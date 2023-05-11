<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class NumberRange extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "doc_number";

    protected $fillable = ['doc_type','doc_year','num_low','num_high','current_num','last_changed','last_changed_by'];

    public $dates = ['last_changed'];


    public function users()
    {
        return $this->belongsTo(User::class,'last_changed_by','id_user');
    }
}
