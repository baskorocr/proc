<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class UserLogRecord extends Model
{
    use HasFactory;
	
	protected $collection = 'user_log';
	
	// protected $primaryKey = 'id_menu';

	protected $fillable = ['id_user','ip_address','datetime_log','attempt','activity'];

	public $dates = ['datetime_log'];

	
	//optional, already set in config::database
	//protected $connection = 'mongodb';
	 public function user()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }
}
