<?php
namespace App\Helpers;

use App\Models\UserLogRecord;
use DB;

class UserLogging {

	static function trace($id_user,$ip_address,$datetime,$attempt,$activity,$info){

		$res = UserLogRecord::create([
							'id_user' => $id_user,
							'ip_address' => $ip_address,
							'datetime_log' => $datetime,
							'attempt' => $attempt,
							'activity' => $activity,
							'info' => $info,
							'user_agent' => !empty($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:null,
						]);

		return $res;
	}



}
