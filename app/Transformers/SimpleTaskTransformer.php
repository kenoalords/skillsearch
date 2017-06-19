<?php

namespace App\Transformers;

// use Auth;
use App\Models\Task;
use League\Fractal\TransformerAbstract;

class SimpleTaskTransformer extends TransformerAbstract
{

	protected $defaultIncludes = [
		'profile'
	];

	public function transform(Task $task)
	{
		return [
			'id'		=> $task->id,
			'user_id'	=> $task->user_id,
			'title'		=> ucwords(strtolower($task->title)),
			'excerpt' => str_limit($task->description, 150),
			'location'	=> ucwords(strtolower($task->location)),
			'category'	=> $task->category,
			'budget'	=> $task->budget,
			'human_budget'=> number_format($task->budget),
			'budget_type' => ucfirst($task->budget_type),
			'slug'		=> $task->slug,
			'expires_at'=> $task->expires,
			'date'		=> $task->created_at->diffForHumans(),
			'can_apply' => $task->open_applications,
			'is_public' => $task->is_public,
			'is_approved' => $task->is_approved,
			'closed' 	=> $task->closed,
			'is_rejected' => $task->is_rejected,
			'href'		=> route('task', ['task'=>$task->id, 'slug'=>$task->slug]),		
		];
	}

	public function includeProfile(Task $task)
	{
		return $this->item($task->user()->first(), new SimpleUserTransformers);
	}
}