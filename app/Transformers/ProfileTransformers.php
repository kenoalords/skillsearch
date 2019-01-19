<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\Portfolio;
use App\Models\User;
use App\Models\SkillsRelations;
use App\Transformers\PortfolioTransformer;
use League\Fractal\TransformerAbstract;

class ProfileTransformers extends TransformerAbstract
{

	protected $defaultIncludes = ['skills', 'portfolios'];

	public function transform(Profile $profile){

		$username = User::where('id', $profile->user_id)->pluck('name')->first();
		$user_points = $profile->user->points()->first();
		$points = ($user_points) ? (int)$user_points->points : 0;
		$phone = $profile->user->phone()->first();

		return [
			'user_id'	=> $profile->user_id,
			'username'	=> $username,
			'first_name'=> $profile->first_name,
			'last_name'	=> $profile->last_name,
			'avatar'	=> $profile->getAvatar(),
			'background'=> $profile->getUserBackground(),
			'location'	=> ucwords($profile->location),
			'gender'	=> $profile->gender,
			'bio'		=> $profile->bio,
			'fullname'	=> $profile->first_name . ' ' . $profile->last_name,
			'verified'	=> $profile->getVerified(),
			'followers'	=> $profile->user->getFollowers($profile->user),
			'following'	=> $profile->user->getFollowing(),
			'url'		=> route('view_profile', ['user'=>$username]),
			'points'	=> $points,
			'verified_email'	=> $profile->verified_email,
			'account_type'		=> $profile->account_type,
			'phone'		=> $phone['number'],
		];
	}

	public function includeSkills(Profile $profile)
	{
		return $this->collection($profile->user->skills->all(), new SkillsTransformer);
	}

	public function includePortfolios(Profile $profile)
	{
		$portfolios = Portfolio::where([
				['user_id', '=', $profile->user_id],
				['is_public', '=', true]
			])->latestFirst()->get();
		return $this->collection($portfolios, new PortfolioTransformer);
	}
}