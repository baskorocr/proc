<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;

class TypeUser extends Authenticable
{
    protected $table = "tipe_user";

    public $dates = ['deleted_at'];
    
  
    //protected $appends = ['photo_url'];
    
    // public function getPhotoUrlAttribute()
    // {
    //     return Storage::drive('images')->exists($this->photo) 
    //     ? url('storage/images/'.$this->photo) : null;
    // }

   
}
