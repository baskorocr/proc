<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ProjectVendorUpload extends Model
{   
 
    // END Connect
    protected $table = "proj_vendor_upload";
    protected $fillable = ['id_assign','id_project','id_product','id_part','id_doc_part','file_nm','upload_n','version_n','doc_required','upload_date','uploader_id','upload_path','download_stat','download_date','downloader_id','id_vendor'];


    public $dates = ['modify_date'];

       public function vendor()
    {
        return $this->belongsTo(Vendor::class,'id_vendor','id_vendor');
    } 

    public function product()
    {
        return $this->belongsTo(Product::class,'id_product','id_product');
    }

    public function part()
    {
        return $this->belongsTo(Part::class,'id_part','id_part');
    }

    public function parts()
    {
        return $this->hasMany(Part::class,'id_part','id_part');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'id_project','id_project');
    }
    
    public function docPart()
    {
        return $this->belongsTo(DocPart::class,'id_doc_part','id_doc_part');
    }
    public function uploader()
    {
        return $this->belongsTo(User::class,'id_user','id_doc_part');
    }

   
    

}

    