<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class DocPart extends Model
{
    // END Connect
    protected $table = "doc_part";

    protected $fillable = ['id_doc_part','nm_doc_part','modify_date','id_user','status','assigned','doc_required','doc_type'];

    public $dates = ['modify_date'];
    
    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }

}

    