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

    protected $fillable = ['doc_type','doc_year','num_low','num_high','current_num','cr_date','ch_by','ch_date'];

    public $dates = ['cr_date','ch_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'cr_by','id_user');
    }
}