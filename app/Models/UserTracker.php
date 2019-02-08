<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTracker extends Model
{
	protected $fillable = ['uuid', 'user_id', 'url', 'tags', 'notes', 'ip', 'user_agent'];

	public function trackable()
	{
		return $this->morphTo();
	}
}
