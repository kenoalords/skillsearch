<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\ServiceRequestResponse;
use App\Transformers\ProfileTransformers;
use League\Fractal\TransformerAbstract;

class ServiceRequestResponseTransformer extends TransformerAbstract
{

	protected $defaultIncludes = [
		'profile'
	];

	public function transform(ServiceRequestResponse $request)
	{
		return [
			'id'		=> $request->id,
			'user_id'	=> $request->user_id,
			'response'	=> $request->response,
			'date'		=> $request->created_at->diffForHumans()
		];
	}

	public function includeProfile(ServiceRequestResponse $request)
	{
		return $this->item(Profile::where('id',$request->user_id)->first(), new ProfileTransformers);
	}

}