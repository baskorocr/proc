<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;

class User extends Authenticable
{
    protected $table = "user";

    public $dates = ['deleted_at'];
    
    protected $hidden = [
        'password', 
        'api_token'
    ];

    protected $fillable = ['role'];

    //protected $appends = ['photo_url'];
    
    // public function getPhotoUrlAttribute()
    // {
    //     return Storage::drive('images')->exists($this->photo) 
    //     ? url('storage/images/'.$this->photo) : null;
    // }

    public function roles()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'foreign_id','id_vendor');
    }
}
