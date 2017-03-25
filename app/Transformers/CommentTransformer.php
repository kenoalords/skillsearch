<?php

namespace App\Transformers;

use App\Models\Comment;
// use App\Transformers\CommentTransformer;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{

	protected $defaultIncludes = [
		'profile', 'replies'
	];

	public function transform(Comment $comment)
	{
		return [
			'id'		=> $comment->id,
			'user_id'	=> $comment->user_id,
			'comment'	=> $comment->comment,
			'date'		=> $comment->created_at->diffForHumans()
		];
	}

	public function includeProfile(Comment $comment)
	{
		return $this->item($comment->user->profile()->first(), new ProfileTransformers);
	}

	public function includeReplies(Comment $comment)
	{
		return $this->collection($comment->replies, new CommentTransformer);
	}
}