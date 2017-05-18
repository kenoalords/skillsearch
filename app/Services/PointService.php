<?php

namespace App\Services;

use App\Models\User;

class PointService
{
	protected $points;

	public function __construct($points)
	{
		$this->points = $points;
	}

	public function addPoint(User $user, $activity)
	{
		// dd($user->points);
		$checkPoints = $user->points;
		if($checkPoints){
			// Increment the user points
			$user->points()->increment('points', $this->points[$activity]);
		} else {
			// Create user point record
			$user->points()->create([
				'points' => $this->points[$activity]
			]);
		}
	}

	public function deletePoint(User $user, $activity)
	{
		$user->points()->decrement('points', $this->points[$activity]);
	}
}