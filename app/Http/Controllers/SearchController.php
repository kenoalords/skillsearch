<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Transformers\ProfileTransformers;
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
}
