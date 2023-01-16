<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class User extends Authenticable
{
    protected $table = "user";

    public $dates = ['deleted_at'];
    
    protected $hidden = [
        'password', 
        'api_token'
    ];

    //protected $appends = ['photo_url'];
    
    // public function getPhotoUrlAttribute()
    // {
    //     return Storage::drive('images')->exists($this->photo) 
    //     ? url('storage/images/'.$this->photo) : null;
    // }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
}
