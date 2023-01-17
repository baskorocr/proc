<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $dates = [
        'deleted_at'
    ];

    public function permissions()
    {
        return $this->embedsMany(Permission::class);
    }
}
