<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;
	
	protected $collection = 'menu_group_list';
	
	// protected $primaryKey = 'id_menu';

	protected $fillable = ['menu_group_name','menu_group_object','last_changed_by','last_changed'];

	public $dates = ['last_changed'];

	
	//optional, already set in config::database
	//protected $connection = 'mongodb';
	
	public function users()
    {
        return $this->belongsTo(User::class,'last_changed_by','id_user');
    }
}
