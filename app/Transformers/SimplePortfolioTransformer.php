<?php

namespace App\Transformers;

use App\Models\Portfolio;
use App\Models\VerifyIdentity;
// use App\Transformers\SimpleUserTransformer;
use League\Fractal\TransformerAbstract;

class SimplePortfolioTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['user_profile'];

	public function transform(Portfolio $portfolio)
	{
		$status = VerifyIdentity::where('user_id', $portfolio->user_id)->first();
		return [
			'id'			=> $portfolio->id,
			'title'		=> $portfolio->title,
			'is_public'	=> $portfolio->is_public,
			'date'		=> $portfolio->created_at->diffForHumans(),
			'created_at'	=> $portfolio->created_at,
			'uid'		=> $portfolio->uid,
			'url'		=> ($portfolio->url !== 'null') ? $portfolio->url : '',
			'thumbnail'	=> $portfolio->getThumbnail(),
			'comment_count'	=> $portfolio->comments()->count(),
			'likes_count'	=> $portfolio->likes()->count(),
			'type'		=> $portfolio->type,
			'is_featured'	=> $portfolio->is_featured,
			'user'		=> $portfolio->user->name,
			'user_id'		=> $portfolio->user_id,
			'verified'	=> ($status && $status->status == 1) ? true : false,
			'link'		=> [
					'url'	=> '/' . $portfolio->user->name . '/portfolio/' . $portfolio->uid,
					'href'	=> config('app.url') . '/' . $portfolio->user->name . '/portfolio/' . $portfolio->uid,
				]
		];
	}

	public function includeUserProfile(Portfolio $portfolio)
	{
		$user = $portfolio->user;
		return $this->item($user, new SimpleUserTransformers);
	}
}