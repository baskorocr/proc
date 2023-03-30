<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class RegisIsoDoc extends Model
{
    //Connect To Other DB
    protected $connection = "mongodbpurch_proc";
    // END Connect
    protected $table = "trn_iso_doc";

    protected $fillable = [
        'doc_year',
        'id_vendor',
        'mat_supply',
        'simply',
        'cert_num',
        'cert_date',
        'cert_name',
        'iso_type_name',
        'exp_date',
        'stat',
        'doc_path',
        'remark',
        'trn_type',
        'ref_doc',
        'ref_doc_year',
        'cr_by',
        'cr_date',
    ];

    public $dates = [];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'id_vendor','id_vendor'); 
    }
}
