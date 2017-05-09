<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\User;
use App\Models\SkillsRelations;
use League\Fractal\TransformerAbstract;

class ProfileTransformers extends TransformerAbstract
{

	protected $defaultIncludes = ['skills'];

	public function transform(Profile $profile){

		$username = User::where('id', $profile->user_id)->pluck('name')->first();

		return [
			'username'	=> $username,
			'first_name'=> $profile->first_name,
			'last_name'	=> $profile->last_name,
			'avatar'	=> $profile->getAvatar(),
			'location'	=> $profile->location,
			'gender'	=> $profile->gender,
			'fullname'	=> $profile->first_name . ' ' . $profile->last_name,
			'verified'	=> $profile->getVerified()
		];
	}

	public function includeSkills(Profile $profile)
	{
		return $this->collection($profile->user->skills->all(), new SkillsTransformer);
	}
}