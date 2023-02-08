<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;


class ProjectDocUpload extends Model
{

    protected $table = "proj_doc_upload";

    protected $fillable = ['id_assign','id_project','id_product','id_part','id_doc_part','file_nm','upload_n','version_n','doc_required','upload_id','upload_path','download_stat','download_date','downloader_id','permit_n','uploader_id'];

    public $dates = ['modify_date'];


    public function users()
    {
        return $this->belongsTo(User::class,'uploader_id','id_user');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'id_project','id_project');
    }

    public function part()
    {
        return $this->belongsTo(Part::class,'id_part','id_part');
    }

    public function docPart()
    {
        return $this->belongsTo(DocPart::class,'id_doc_part','id_doc_part');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'id_product','id_product');
    }
   
}

    