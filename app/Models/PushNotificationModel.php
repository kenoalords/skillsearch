<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotificationModel extends Model
{
	
	protected $table = 'push_notifications';

	protected $fillable = ['user_id', 'endpoint'];

	public function user()
	{
		return $this->hasOne(User::class);
	}
}
