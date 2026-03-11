<?php

namespace App\Models\masterData;

use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $collection = 'projects';
    protected $fillable = ['name_project', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', '_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}