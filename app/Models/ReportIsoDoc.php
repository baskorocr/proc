<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportIsoDoc extends Model
{
    use HasFactory;

    // public $dates = ['exp_date'];
    public function vendor(){
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }
}
