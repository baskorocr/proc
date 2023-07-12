<?php
namespace App\Helpers;

use App\Models\LogTransaction;
use Jenssegers\Agent\Agent;

class Logger {

	public $menu;
	public $code;
	public $step;
	public $function;
	public $controller;
	public $company_code;
	public $action_by;
	public $user_id;
	public $status_code;
	public $messages;
	public $status;
	public $start_transaction;

	function trace(){
		if(class_exists("Agent"))
		{
			$agent = new Agent();
			$device = $agent->device();
			$platform = $agent->platform();
			$browser = $agent->browser();
			$version = $agent->version($platform);
			$platver = $platform." ".$version;
		} else
		{
			$type=null;
			$device = null;
			$platform =  null;
			$browser =  null;
			$version =  null;
			$platver =  null;
		}


		$transaction = new LogTransaction;

		$transaction->menu = $this->menu;
		$transaction->code = $this->code;
		$transaction->step = $this->step;
		$transaction->messages = $this->messages;
		$transaction->function = $this->function;
		$transaction->controller = $this->controller;
		$transaction->company_code = $this->company_code;
		$transaction->action_by = $this->action_by;
		$transaction->user_id = $this->user_id;
		$transaction->status_code = $this->status_code;
		$transaction->memory_usage = $this->get_mem();
		$transaction->memory_byte = $this->get_byte();
		$transaction->status = $this->status;
		$transaction->start_transaction = date('Y-m-d H:i:s');
		$transaction->platform = $browser;
		$transaction->browser = $platver;
		$transaction->ip = request()->ip();

		return $transaction->save();
	}



	///CONVERTER
	private function get_mem()
    {
        /* Currently used memory */
        $mem_usage = memory_get_usage();

        if($mem_usage < 1024) {
            return $mem_usage . 'bytes';
        } elseif ($mem_usage < 1048576) {
            return round($mem_usage / 1024,2) . 'KB';
        } else {
            return round($mem_usage / 1048576,2) . 'MB';
        }
    }

    private function get_byte()
    {
        /* Currently used memory */
        $mem_usage = memory_get_usage();

        return $mem_usage;
    }




}
