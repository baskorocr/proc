<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class AccessGroupList extends Model
{
    use HasFactory;
	
	protected $collection = 'access_group_list';
	
	protected $primaryKey = 'id_access_group';
	
	//optional, already set in config::database
	protected $connection = 'mongodb';
	
}
