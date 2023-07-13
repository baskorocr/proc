<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\Model;

class LogTransaction extends Model
{
    use HasFactory;
	
	protected $collection = 'log_transaction';

	protected $fillable = ['menu','code','manifest','messages','step','function','controller','company_code','action_by','user_id','status_code','memory_usage','memory_byte','status', 'result', 'start_transaction', 'time','platform','browser','ip'];
}
