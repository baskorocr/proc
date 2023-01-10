<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

	protected $table = 'user';
	
	protected $primaryKey = 'id_user';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        /* 'name', */
        'nm_user', 
        'username',
        'password',
        'id_tipe_user',
        'status_user',
        'role',
        'id_session',
        'id_access_group',
        'foreign_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        /* 'password', */
        /* 'remember_token', */
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        /* 'email_verified_at' => 'datetime', */
    ];
	
	
	public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id_vendor', 'foreign_id');
    }
}
