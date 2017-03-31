<?php

namespace App\Transformers;

use App\Models\User;
use App\Models\Follower;
use App\Models\Portfolio;
use App\Models\Activity;
use League\Fractal\TransformerAbstract;
use App\Transformers\PortfolioTransformer;

class FollowersTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['portfolio'];

	public function transform(Activity $activity)
	{
		return [
			'title'		=> $activity->title,
			'type'		=> $activity->type,
			'username'	=> $activity->user->name,
			'avatar'	=> $activity->user->profile->getAvatar(),
			'fullname'	=> $activity->user->profile->first_name . ' ' . $activity->user->profile->last_name,
			'link'		=> [
				'href'	=> '/'.$activity->user->name,
				'url'	=> config('app.url') . '/' . $activity->user->name
			],
			'created_at'=> $activity->created_at,
			'date'		=> $activity->created_at->diffForHumans(),
		];
	}

	public function includePortfolio(Activity $activity)
	{
		if($activity->type === 'portfolio'){
			$portfolio = Portfolio::where('id',$activity->activable_id)->first();
			// dd($portfolio);
			if($portfolio !== null){
				return $this->item($portfolio, new PortfolioTransformer);
			} else {
				return null;
			}
		} else {
			return;
		}
	}
}