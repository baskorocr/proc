<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'permission_id', 
        'allow'
    ];

    public function children()
    {
        return $this->hasMany('App\Permission', 'parent_id', '_id')->orderBy('order_number');
    }
}
