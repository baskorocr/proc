<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Vendor extends Model
{
    protected $table = "vendor";
    protected $fillable = ['id_vendor','purch_org','nm_vendor','allias','street','district','postal_code','city','country','region','phone_1','vat_reg','order_curr','pay_term','sales_person','phone_2','vend_email','status_vendor'];
    

    public function user()
    {
        return $this->belongsTo(User::class,'id_vendor','foreign_id');
    }
}
