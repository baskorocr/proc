<?php
namespace App\Helpers;

use App\Models\UserLogRecord;
use DB;
use Jenssegers\Agent\Agent;

class UserLogging {

	static function trace($id_user,$ip_address,$datetime,$attempt,$activity,$info){
		if(class_exists("Agent"))
		{
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
							'platform' =>  $platver,
							'browser' => $browser,

						]);

		return $res;
	}



}
