<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\Portfolio;
use App\Models\User;
use App\Models\Phone;
use App\Models\SkillsRelations;
use App\Transformers\PortfolioTransformer;
use League\Fractal\TransformerAbstract;

class UserTransformers extends TransformerAbstract
{

	protected $defaultIncludes = ['skills', 'portfolios'];


	public function transform(User $user){

		$profile = Profile::where('user_id', $user->id)->first();
		$phone = Phone::where('user_id', $user->id)->first();

		return [
			'username'	=> $user->name,
			'first_name'=> $profile->first_name,
			'last_name'	=> $profile->last_name,
			'avatar'	=> $profile->getAvatar(),
			'location'	=> $profile->location,
			'gender'	=> $profile->gender,
			'bio'		=> $profile->bio,
			'fullname'	=> $profile->first_name . ' ' . $profile->last_name,
			'verified'	=> $profile->getVerified(),
			'has_instagram'	=> ($profile->user->instagram()->first()) ? true : false,
			'followers'	=> $profile->user->getFollowers($user),
			'following'	=> $profile->user->getFollowing(),
			'phone'		=> ($phone) ? true : false,
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
			])->take(3)->get();
		return $this->collection($portfolios, new PortfolioTransformer);
	}
}