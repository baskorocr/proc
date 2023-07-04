<?php
namespace App\Helpers;

use App\Models\UserLogRecord;
use DB;
use Jenssegers\Agent\Agent;

class UserLogging {

	static function trace($id_user,$ip_address,$datetime,$attempt,$activity,$info){
		$agent = new Agent();
		if($agent->isMobile())
		{
			$type = "M";
		} elseif($agent->isTablet()){
			$type ="T";
		} elseif($agent->isDesktop()){
			$type = "D";
		} else {
			$type = '-';
		}

		$device = $agent->device();
		$platform = $agent->platform();
		$browser = $agent->browser();
		$version = $agent->version($platform);

		$res = UserLogRecord::create([
							'id_user' => $id_user,
							'ip_address' => $ip_address,
							'datetime_log' => $datetime,
							'attempt' => $attempt,
							'activity' => $activity,
							'info' => $info,
							// 'user_agent' => !empty($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:null,
							'platform_type' => $type,
							'device' =>  (!$device ? null:$device),
							'platform' =>  $platform." ".$version,
							'browser' => $browser,

						]);

		return $res;
	}



}
