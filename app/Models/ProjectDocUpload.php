<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;


class ProjectDocUpload extends Model
{

    protected $table = "proj_doc_upload";

    protected $fillable = ['id_assign','id_product','id_part','id_doc_part','file_nm','upload_n','version_n','doc_required','upload_id','upload_path','download_stat','download_date','downloader_id','permit_n'];

    public $dates = ['modify_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }
    
   
}

    