<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class PurchasingProcess extends Model
{
    use HasFactory;

    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "po_list";

    protected $fillable = ['po_num','revno','plant','id_vendor','nm_vendor','vend_email','doc_date','pgr','curr','file_nm'];

    public $dates = ['doc_date','downloaded','last_change','sent','aprvdt','aprvtm','revdt','revtm'];

    public function vendors()
    {
        return $this->belongsTo(Vendor::class,'id_vendor','id_vendor');
    }

      public function user()
    {
        return $this->belongsTo(User::class,'id_vendor','foreign_id');
    }
}
