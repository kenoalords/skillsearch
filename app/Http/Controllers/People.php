<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\SkillsRelations;
use App\Transformers\ProfileTransformers;
use App\Transformers\PortfolioTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use App\Traits\Orderable;
// use Illuminate\Support\Collection;

class People extends Controller
{
    use Orderable;

    public function index(User $user, Profile $profile){
    	
    	$collection = $profile->where('account_type', 1)->isPublic()->get();

    	// $people = fractal()->collection($collection)
    	// 			->parseIncludes(['skills'])
    	// 			->transformWith(new ProfileTransformers)
    	// 			->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
    	// 			->toArray();
    	
    	// dd($collection);
    	return view('profile.people')->with([
            'profiles' => $collection,
            'locations'=> $collection->groupBy('location')
        ]);

    }


    public function profile(Request $request, User $user){
    	$profile = $user->profile()->get()->first();
        $skills = $user->skills()->get();
        $portfolios = fractal()->collection($user->portfolio()->isPublic()->get())
                            ->transformWith(new PortfolioTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
    	// dd(collect($portfolios));
    	return view('profile.profile')->with([
    		'profile' 	=> $profile,
    		'skills'	=> $skills,
            'portfolios'=> $portfolios,
            'name'      => $user->name,
    	]);
    }

    public function hire(Request $request, User $user)
    {
        $profile = $user->profile()->get()->first();
        return view('profile.hire')->with([
            'profile' => $profile,
            'name'  => $user->name
        ]);
    }
    
}
