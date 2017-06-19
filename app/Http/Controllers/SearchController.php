<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Task;
use App\Models\Skills;
use App\Transformers\ProfileTransformers;
use App\Transformers\TaskTransformer;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

class SearchController extends Controller
{
	use Searchable;
	
    public function searchProfiles(Request $request, Profile $profile)
    {
    	$results = $profile->search( $request->term . ' ' . $request->location )->where('is_public', 1)->get();
        $people = fractal()->collection($results)
                            ->transformWith(new ProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        $collection = collect($people)->reject(function ($profile, $key){
        									return count($profile['portfolios']) < 1;
        							   	})
                                        ->sortByDesc('portfolios');
    	return view('search')->with('profiles', $collection);
    }

    public function searchJobs(Request $request, Task $task, Skills $skills)
    {
        $results = $task->search( $request->skill . ' ' . $request->location )->where('is_public', 1)->get();
        $tasks = fractal()->collection($results)
                            ->transformWith(new TaskTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        return view('search.jobs')->with([ 'tasks' => $tasks, 'skills' => $skills->all() ]);
    }
}
