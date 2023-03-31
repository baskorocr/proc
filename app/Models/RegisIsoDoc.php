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
        'trn_id',
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
    ////DRIVER DATES
    public function getExpDateAttribute( $value ) 
    {


        $date = explode("/",$value); 
        $d = strlen(@$date[0]) == 1 ? "0".@$date[0]:@$date[0];;
        $m = strlen(@$date[1]) == 1 ? "0".@$date[1]:@$date[1];
        $y= @$date[2];

        $date_full = date('Y-m-d',strtotime($y."-".$m.'-'.$d));
          // $this->attributes['exp_date'] = $date_full;
          return $date_full;
    }

    public function getCertDateAttribute($value)
    {
        $date = explode("/",$value); 
        $d = strlen(@$date[0]) == 1 ? "0".@$date[0]:@$date[0];;
        $m = strlen(@$date[1]) == 1 ? "0".@$date[1]:@$date[1];
        $y= @$date[2];

        $date_full = date('Y-m-d',strtotime($y."-".$m.'-'.$d));
          // $this->attributes['exp_date'] = $date_full;
          return $date_full;
    }
}
