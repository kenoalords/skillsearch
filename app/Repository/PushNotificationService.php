<?php

namespace App\Repository;

use App\Models\PushNotificationModel;
use App\Models\User;


class PushNotificationService
{
	public function item(User $user, $message, $action=null)
	{
		$token = json_decode($user->pushNotification->endpoint);
		// dd(json_decode($token));
		// PushNotification::app('android')
		// 	->to($token->endpoint)
		// 	->send($message);
	}
}