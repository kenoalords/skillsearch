<?php

namespace App\Transformers;

use App\Models\Gig;
use App\Models\User;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;

class GigTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['user'];
	public function transform(Gig $gig)
	{
		return [
			'id'			=> $gig->id,
			'user_id'		=> $gig->user_id,
			'title'		=> $gig->title,
			'description'	=> $gig->description,
			'category'	=> $gig->category,
			'is_public'	=> $gig->is_public,
			'regular_price'=> $gig->regular_price,
			'sale_price'	=> $gig->sale_price,
			'image'		=> $gig->getFile(),
			'is_featured'	=> $gig->is_featured,
			'delivery_time'=> $gig->delivery_time,
			'is_local'	=> $gig->is_local,
			'uid'		=> $gig->uid,
			'slug'		=> $gig->slug,
			'deal'		=> ($gig->regular_price > $gig->sale_price),
			'percentage'	=> (int)floor(($gig->regular_price - $gig->sale_price) / $gig->regular_price * 100),
		];
	}

	public function includeUser(Gig $gig)
	{
		$user = User::where('id', $gig->user_id)->first();
		return $this->item($user, new SimpleUserTransformers);
	}
}