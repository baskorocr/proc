<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ProjectVendorAssign extends Model
{   
 
    // END Connect
    protected $table = "proj_vendor_assign";
    protected $fillable = [ 'id_assign','id_project','id_vendor','id_product','id_part','id_doc_part','check_params','comment','check_status','checker_id','check_date' ];

    public $dates = ['modify_date','check_date'];

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

    // public function vendor()
    // {
    //     return $this->belongsTo(Vendor::class,'id_vendor','id_vendor');
    // }

    public function parts()
    {
        return $this->hasMany(Part::class,'id_product','id_product');
    } 

    public function ProjDocAssign()
    {
        return $this->belongsTo(ProjectDocUpload::class, 'id_project', 'id_project');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'id_project','id_project');
    }
    
    public function docPart()
    {
        return $this->belongsTo(DocPart::class,'id_doc_part','id_doc_part');
    }

   

}

    