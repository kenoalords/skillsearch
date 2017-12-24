<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Profile;
use App\Models\Portfolio;
use App\Models\User;
use App\Models\Task;
use App\Models\Skills;
use App\Transformers\ProfileTransformers;
use App\Transformers\SearchProfileTransformers;
use App\Transformers\TaskTransformer;
use App\Transformers\PortfolioTransformer;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

class SearchController extends Controller
{
	use Searchable;
	
    public function searchProfiles(Request $request, Profile $profile)
    {
    	$results = $profile->search( $request->term . ' ' . $request->location )->where('is_public', 1)->get();
        $people = fractal()->collection($results)
                            ->transformWith(new SearchProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        $collection = collect($people)->reject(function ($profile, $key){
        									return count($profile['portfolios']) < 1;
        							   	})
                                        ->sortByDesc('portfolios');
    	return view('search')->with('profiles', $collection);
    }

    public function searchPortfolios(Request $request, Portfolio $portfolio)
    {
        $skills = $request->term;
        $location = $request->location;
        $search = $portfolio->join('profiles', function($join) use ($location){
                                $join->on('portfolios.user_id', '=', 'profiles.user_id')
                                     ->where('profiles.location', 'like', '%'.$location.'%');
                            })
                            ->where(function($query) use ($skills){
                                $query->whereRaw("MATCH(portfolios.skills) AGAINST('$skills')");
                                $query->orWhereRaw("MATCH(portfolios.title) AGAINST('$skills')");
                                $query->orWhereRaw("MATCH(portfolios.description) AGAINST('$skills')");
                            })
                            ->where('portfolios.is_public', true)
                            ->whereNotNull('portfolios.thumbnail')
                            ->orderBy('portfolios.is_featured', 'desc')
                            ->orderBy('portfolios.updated_at', 'asc')
                            ->get();
        $portfolios = fractal()->collection($search)
                                ->transformWith(new PortfolioTransformer)
                                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                ->toArray();
        return view('search')->with('portfolios', $portfolios);
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
