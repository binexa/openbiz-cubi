<?php

use Openbiz\Openbiz;

require_once OPENBIZ_APP_MODULE_PATH.'/websvc/lib/WebsvcService.php';
class userService extends  WebsvcService
{
	public function getStatus()
	{
		$result = array();
		$userId = Openbiz::$app->getUserProfile("Id");
		if($userId)
		{
			$result['login_status'] = 1;
			$result['display_name'] = Openbiz::$app->getUserProfile("profile_display_name");
			$result['email'] 		= Openbiz::$app->getUserProfile("email");
		}
		else
		{
			$result['login_status'] = 0;			
		}
		return $result;
	}
}
