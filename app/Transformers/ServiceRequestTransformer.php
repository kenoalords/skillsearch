<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\ServiceRequest;
use App\Transformers\ProfileTransformers;
use League\Fractal\TransformerAbstract;

class ServiceRequestTransformer extends TransformerAbstract
{

	protected $defaultIncludes = [
		'sender_profile', 'receiver_profile'
	];

	public function transform(ServiceRequest $request)
	{
		return [
			'id'		=> $request->id,
			'user_id'	=> $request->user_id,
			'receiver_id'	=> $request->receiver_id,
			'subject'	=> $request->subject,
			'body'	=> $request->body,
			'skills'	=> $request->skills,
			'read'	=> $request->read,
			'date'		=> $request->created_at->diffForHumans()
		];
	}

	public function includeSenderProfile(ServiceRequest $request)
	{
		return $this->item(Profile::where('id',$request->user_id)->first(), new ProfileTransformers);
	}

	public function includeReceiverProfile(ServiceRequest $request)
	{
		return $this->item(Profile::where('id',$request->receiver_id)->first(), new ProfileTransformers);
	}
}