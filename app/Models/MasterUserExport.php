<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class MasterUserExport extends Model
{
    use HasFactory;
	
	protected $collection = 'users';
	
	// protected $primaryKey = 'id_menu';

	protected $fillable = ['id_user','nm_user','password','id_tipe_user','status_user','role','foreign_id','role_id','is_vendor','id_access_group'];

	public $dates = ['last_changed'];

	
	//optional, already set in config::database
	//protected $connection = 'mongodb';

	  public function vendor()
    {
        return $this->belongsTo(Vendor::class,'foreign_id','id_vendor');
    }

    public function tipeUser()
    {
        return $this->belongsTo(TypeUser::class,'id_tipe_user','id_tipe_user');
    } 

    public function roles()
    {
        return $this->belongsTo(Role::class,'role_id','_id');
    } 

    public function access_group()
    {
        return $this->belongsTo(AccessGroup::class,'id_access_group','id_access_group');
    }

}
