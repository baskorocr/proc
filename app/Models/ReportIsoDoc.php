<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportIsoDoc extends Model
{
    use HasFactory;

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }
}
