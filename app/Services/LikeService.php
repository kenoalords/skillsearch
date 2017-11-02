<?php

namespace App\Services;

use Auth;
use App\Models\User;
use App\Models\Like;

class LikeService
{
	protected $user;

	public function __construct()
	{
		$this->user = Auth::user();
	}
}