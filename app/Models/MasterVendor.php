<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;

//Extending the base model
//Reference: https://github.com/jenssegers/laravel-mongodb#eloquent
use Jenssegers\Mongodb\Eloquent\Model;

class MasterVendor extends Model
{
    use HasFactory;
	
	protected $collection = 'vendor';
	
	// protected $primaryKey = 'id_menu';

	protected $fillable = ['id_vendor','nm_vendor','alias','street','district', 'postal_code', 'city','country','region','phone_1','vat_reg','order_curr','pay_term','sales_person','phone_2','status_vendor'];

	public $dates = ['last_changed'];

	
	//optional, already set in config::database
	//protected $connection = 'mongodb';

}
