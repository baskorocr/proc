<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class DocCheckList extends Model
{
    // END Connect
    protected $table = "doc_check_list";

    protected $fillable = ['id_check','id_doc_part','modify_date','id_user'];

    public $dates = ['modify_date'];
    
    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }
    public function docParts()
    {
        return $this->belongsTo(DocPart::class,'id_doc_part','id_doc_part');
    }

}

    