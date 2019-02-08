<?php

namespace App\Http\Controllers;

use App\Models\PushNotificationModel;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
	public function subscribe(Request $request, PushNotificationModel $pushNotification)
	{
		$this->validate($request, [
			'endpoint' => 'required',
		]);

		// Save push endpoint to database
		$endpoint = json_decode($request->endpoint);
		$record = $request->user()->updatePushSubscription($endpoint->endpoint, $endpoint->keys->p256dh, $endpoint->keys->auth);
		if ( $record ){
			return response()->json(true, 200);
		}
	}
}
