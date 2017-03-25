<?php

namespace App\Transformers;

use App\Models\Portfolio;
use League\Fractal\TransformerAbstract;

class PortfolioTransformer extends TransformerAbstract
{

	public function transform(Portfolio $portfolio)
	{
		return [
			'title'		=> $portfolio->title,
			'description'=> $portfolio->description,
			'is_public'	=> $portfolio->is_public,
			'date'		=> $portfolio->created_at->diffForHumans(),
			'uid'		=> $portfolio->uid,
			'skills'	=> $portfolio->skills,
			'url'		=> $portfolio->url,
			'thumbnail'	=> $portfolio->getThumbnail(),
			'comment_count'	=> $portfolio->comments()->count(),
			'likes_count'	=> $portfolio->likes()->count(),
			'type'		=> $portfolio->type,
			'user'		=> $portfolio->user->name,
			'user_id'	=> $portfolio->user_id,
			'link'		=> [
					'url'	=> '/' . $portfolio->user->name . '/portfolio/' . $portfolio->uid,
					'href'	=> config('app.url') . '/' . $portfolio->user->name . '/portfolio/' . $portfolio->uid,
				],
			'user_profile'	=> [
				'first_name'	=> $portfolio->user->profile->first_name,
				'last_name'		=> $portfolio->user->profile->last_name,
				'fullname'		=> $portfolio->user->profile->first_name . ' ' . $portfolio->user->profile->last_name,
				'avatar'		=> $portfolio->user->profile->getAvatar()
			],
			'views'		=> $portfolio->views()->count(),
		];
	}
}