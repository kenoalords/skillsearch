<?php

namespace App\Transformers;

// use Auth;
use App\Models\User;
use App\Models\ApplicationResponse;
use League\Fractal\TransformerAbstract;

class ApplicationResponseTransformer extends TransformerAbstract
{

	protected $defaultIncludes = [
		'profile'
	];

	public function transform(ApplicationResponse $application)
	{
		return [
			'id'		=> $application->id,
			'user_id'	=> $application->user_id,
			'task_id'	=> $application->task_id,
			'application_id'=> $application->application_id,
			'response' 	=> $application->response,
			'date'		=> $application->created_at->diffForHumans(),
		];
	}

	public function includeProfile(ApplicationResponse $application)
	{
		$user = User::where('id', $application->user_id)->first();
		return $this->item($user, new UserTransformers);
	}

	// public function includeReplies(Comment $comment)
	// {
	// 	return $this->collection($comment->replies, new CommentTransformer);
	// }
}