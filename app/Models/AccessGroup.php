<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class AccessGroup extends Model
{
    use HasFactory;

    protected $collection = 'access_group_list';

    // protected $primaryKey = 'id_access_group';

    protected $fillable = ['access_group_name','last_changed_by','last_changed'];

    public $dates = ['last_changed'];

    public function users()
    {
        return $this->belongsTo(User::class,'last_changed_by','id_user');
    }

    //optional, already set in config::database
    // protected $connection = 'mongodb';
}
