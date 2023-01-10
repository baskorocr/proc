<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
	
	protected $collection = 'vendor';
	
	protected $primaryKey = 'id_vendor';
	
	//optional, already set in config::database
	protected $connection = 'mongodb';
	
	public function user()
    {
        return $this->belongsTo(User::class, 'foreign_id', 'id_vendor');
    }
}
