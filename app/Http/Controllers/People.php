<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Skills;
use App\Models\SkillsRelations;
use App\Transformers\ProfileTransformers;
use App\Transformers\UserTransformers;
use App\Transformers\PortfolioTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use App\Traits\Orderable;
// use Illuminate\Support\Collection;

class People extends Controller
{
    use Orderable;

    public function index(User $user, Profile $profile, Skills $skills ){
    	
    	$collection = $user->has('portfolio')->withCount(['portfolio' => function($query){
                                $query->where('is_public', true);
                            }])->orderBy('portfolio_count', 'desc')->take(10)->get();

        $people = fractal()->collection($collection)
                            ->transformWith(new UserTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        $skills = $skills->orderAlphabetically()->get();

        return view('profile.people')->with([
                'profiles'  => $people,
                'skills'    => $skills,
            ]);

    }


    public function profile(Request $request, User $user, Profile $profile){
    	$profile = $user->profile()->get()->first();
        $skills = $user->skills()->get();
        $portfolios = fractal()->collection($user->portfolio()->isPublic()->get())
                            ->transformWith(new PortfolioTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
    	// dd(collect($portfolios));
        $others = fractal()->collection($profile->getOtherProfiles($user)->isPublic()->take(4)->get())
                            ->transformWith(new ProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        // dd($others);
        
    	return view('profile.profile')->with([
    		'profile' 	=> $profile,
    		'skills'	=> $skills,
            'portfolios'=> $portfolios,
            'name'      => $user->name,
            'others'    => $others
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

    public function about(Request $request, User $user)
    {
        $profile = $user->profile()->get()->first();

        $others = fractal()->collection($profile->getOtherProfiles($user)->isPublic()->take(4)->get())
                            ->transformWith(new ProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();

        return view('profile.profile-about')->with([
            'profile' => $profile,
            'name'  => $user->name,
            'others' => $others
        ]);
    }
    
}
