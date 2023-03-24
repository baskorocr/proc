<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class MasterUser extends Model
{
    use HasFactory;
	
	protected $collection = 'users';
	
	// protected $primaryKey = 'id_menu';

	protected $fillable = ['id_user','nm_user','password','id_tipe_user','status_user','role'];

	public $dates = ['last_changed'];

	
	//optional, already set in config::database
	//protected $connection = 'mongodb';

	  public function vendor()
    {
        return $this->belongsTo(Vendor::class,'foreign_id','id_vendor');
    }

}
