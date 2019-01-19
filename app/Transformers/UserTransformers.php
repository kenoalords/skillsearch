<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\Portfolio;
use App\Models\User;
use App\Models\Phone;
use App\Models\Point;
use App\Models\SkillsRelations;
use App\Transformers\PortfolioTransformer;
use League\Fractal\TransformerAbstract;

class UserTransformers extends TransformerAbstract
{

	protected $defaultIncludes = ['skills', 'portfolios'];


	public function transform(User $user){
		$profile = Profile::where(['user_id'=> $user->id])->first();
		$point = Point::where(['user_id'=> $user->id])->first();
		$points = ($point) ? $point->points : 0;
		return [
			'username'		=> $user->name,
			'first_name'		=> $profile->first_name,
			'last_name'		=> $profile->last_name,
			'avatar'			=> $profile->getAvatar(),
			'location'		=> $profile->location,
			'gender'			=> $profile->gender,
			'bio'			=> $profile->bio,
			'fullname'		=> $profile->first_name . ' ' . $profile->last_name,
			'verified'		=> $profile->getVerified(),
			'verified_email'	=> $profile->verified_email,
			'followers'		=> $profile->user->getFollowers($user),
			'following'		=> $profile->user->getFollowing(),
			'points'			=> $points,
		];
	}

	public function includeSkills(User $user)
	{
		$skills = $user->skills()->get();
		return $this->collection($skills, new SkillsTransformer);
	}

	public function includePortfolios(User $user)
	{
		$portfolios = Portfolio::where([
				['user_id', '=', $user->id],
				['is_public', '=', true]
			])->latestFirst()->take(3)->get();
		return $this->collection($portfolios, new PortfolioTransformer);
	}
}