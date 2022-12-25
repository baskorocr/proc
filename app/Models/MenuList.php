<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class MenuList extends Model
{
    use HasFactory;
	
	protected $collection = 'menu_list';
	
	protected $primaryKey = 'id_menu';
	
	//optional, already set in config::database
	protected $connection = 'mongodb';
	
}
