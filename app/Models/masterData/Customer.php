<?php

namespace App\Models\masterData;

use Jenssegers\Mongodb\Eloquent\Model; // gunakan Jenssegers Mongodb
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    // Jika menggunakan koneksi MongoDB khusus, definisikan nama koneksinya di sini
    protected $collection = 'customers';

  

    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}