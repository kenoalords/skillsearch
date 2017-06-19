<?php

namespace App\Transformers;

// use Auth;
use App\Models\Application;
use League\Fractal\TransformerAbstract;

class ApplicationTransformer extends TransformerAbstract
{

	protected $defaultIncludes = [
		'profile', 'responses', 'task'
	];

	public function transform(Application $application)
	{
		return [
			'id'		=> $application->id,
			'user_id'	=> $application->user_id,
			'task_id'	=> $application->task_id,
			'application'=> $application->application,
			'budget' 	=> $application->budget,
			'human_budget' 	=> number_format($application->budget),
			'date'		=> $application->created_at->diffForHumans(),
		];
	}

	public function includeProfile(Application $application)
	{
		return $this->item($application->user, new UserTransformers);
	}

	public function includeResponses(Application $application)
	{
		$response = $application->response()->get();
		return $this->collection($response, new ApplicationResponseTransformer);
	}

	public function includeTask(Application $application)
	{
		$response = $application->task()->get();
		return $this->collection($response, new SimpleTaskTransformer);
	}
}