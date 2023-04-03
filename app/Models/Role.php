<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $dates = [
        'deleted_at','created_at','updated_at'
    ];

    protected $fillable = ['name','description','permissions','created_by','changed_by','updated_at','created_at'];

    public function permissions()
    {
        return $this->embedsMany(Permission::class);
    }
}
