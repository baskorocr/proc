<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ProductForProject extends Model
{   
 
    // END Connect
    protected $table = "product_for_project";

    protected $fillable = ['id_assign','id_project','id_product','modify_date','id_user'];

    public $dates = ['modify_date'];

   
    public function product()
    {
        return $this->belongsTo(Product::class,'id_product','id_product');
    }

    public function part()
    {
        return $this->belongsTo(Part::class,'id_product','id_product');
    }

    public function parts()
    {
        return $this->hasMany(Part::class,'id_product','id_product');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'id_project','id_project');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }

}

    