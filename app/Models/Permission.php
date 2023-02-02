<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Permission;

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

    protected $casts = [
        'order_number' => 'float',
    ];
    public function children()
    {
        return $this->hasMany('App\Models\Permission', 'parent_id', '_id')->orderBy('order_number');
    }
}
