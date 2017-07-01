<?php

namespace App\Transformers;

// use Auth;
use App\Models\Task;
use App\Models\Application;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class TaskTransformer extends TransformerAbstract
{

	protected $defaultIncludes = [
		'profile', 'applications'
	];

	public function transform(Task $task)
	{
		if($task->application_limit !== 0){
			$limit = (int)($task->application_limit - $task->applications()->get()->count());
		} else {
			$limit = 0;
		}
		$expires_date = new Carbon($task->expires, 'Africa/Lagos');
		return [
			'id'		=> $task->id,
			'user_id'	=> $task->user_id,
			'title'		=> ucwords(strtolower($task->title)),
			'description' => $task->description,
			'excerpt' => str_limit($task->description, 150),
			'location'	=> ucwords(strtolower($task->location)),
			'category'	=> $task->category,
			'budget'	=> $task->budget,
			'human_budget'=> number_format($task->budget),
			'budget_type' => ucfirst($task->budget_type),
			'slug'		=> $task->slug,
			'expires_at'=> $task->expires,
			'expires_human' => $expires_date->toFormattedDateString(),
			'date'		=> $task->created_at->diffForHumans(),
			'can_apply' => $task->open_applications,
			'is_approved' => $task->is_approved,
			'is_rejected' => $task->is_rejected,
			'is_public' => $task->is_public,
			'closed' 	=> $task->closed,
			'href'		=> route('task', ['task'=>$task->id, 'slug'=>$task->slug]),
			'application_left' => $limit,
			'application_limit' => ($task->application_limit > 0) ? $task->application_limit : -1,		
		];
	}

	public function includeProfile(Task $task)
	{
		return $this->item($task->user()->first(), new UserTransformers);
	}

	public function includeApplications(Task $task)
	{
		return $this->collection($task->applications()->get(), new ApplicationTransformer);
	}
}