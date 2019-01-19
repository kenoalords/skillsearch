<?php

namespace App\Transformers;

use App\Models\Portfolio;
use App\Models\VerifyIdentity;
// use App\Transformers\SimpleUserTransformer;
use League\Fractal\TransformerAbstract;

class PortfolioTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['user_profile', 'files'];

	public function transform(Portfolio $portfolio)
	{
		$status = VerifyIdentity::where('user_id', $portfolio->user_id)->first();
		$number = $portfolio->user->phone()->first();
		$skills = $portfolio->user->skills()->get();
		return [
			'title'		=> $portfolio->title,
			'description'=> $portfolio->description,
			'is_public'	=> $portfolio->is_public,
			'date'		=> $portfolio->created_at->diffForHumans(),
			'created_at'	=> $portfolio->created_at,
			'uid'		=> $portfolio->uid,
			'skills'		=> $portfolio->skills,
			'url'		=> ($portfolio->url !== 'null') ? $portfolio->url : '',
			'thumbnail'	=> $portfolio->getThumbnail(),
			'comment_count'	=> $portfolio->comments()->count(),
			'likes_count'	=> $portfolio->likes()->count(),
			'type'		=> $portfolio->type,
			'is_featured'	=> $portfolio->is_featured,
			'user'		=> $portfolio->user->name,
			'user_id'	=> $portfolio->user_id,
			'verified'	=> ($status && $status->status == 1) ? true : false,
			'link'		=> [
					'url'	=> '/' . $portfolio->user->name . '/portfolio/' . $portfolio->uid,
					'href'	=> config('app.url') . '/' . $portfolio->user->name . '/portfolio/' . $portfolio->uid,
				],			
			'views'		=> $portfolio->views()->count(),
			'has_liked'	=> $portfolio->userHasLiked(),
		];
	}

	public function includeUserProfile(Portfolio $portfolio)
	{
		$user = $portfolio->user;
		return $this->item($user, new SimpleUserTransformers);
	}

	public function includeFiles(Portfolio $portfolio)
	{
		$files = $portfolio->files()->get();
		return $this->collection($files, new FileTransformer);
	}
}