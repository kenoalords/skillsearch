<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Skills;
use App\Models\SkillsRelations;
use App\Transformers\ProfileTransformers;
use App\Transformers\UserTransformers;
use App\Transformers\PortfolioTransformer;
use App\Services\InstagramService;
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
    	// dd($skills);
        $others = User::where('id', '!=', $user->id)->whereHas('skills', function($query) use ($skills){
            $skillset = [];
            foreach($skills as $skill){
                $skillset[] = $skill->skill;
            }
            $query->whereIn('skill', $skillset);
        })->has('portfolio')->take(10)->get();

        $other_profiles = [];
        if($others){
            foreach($others as $user){
                $other = $user->profile()->isPublic()->get()->first();
                if($other){
                    $other_profiles[] = fractal()->item($other)
                            ->transformWith(new ProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
                }
            }
        }
        
        
        // dd($other_profiles);
        $instagram = $user->instagram()->first();
        
    	return view('profile.profile')->with([
    		'profile' 	=> $profile,
    		'skills'	=> $skills,
            'instagram' => $instagram,
            'portfolios'=> $portfolios,
            'name'      => $user->name,
            'others'    => $other_profiles
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
        $skills = $user->skills()->get();
        $others = User::where('id', '!=', $user->id)->whereHas('skills', function($query) use ($skills){
            $skillset = [];
            foreach($skills as $skill){
                $skillset[] = $skill->skill;
            }
            $query->whereIn('skill', $skillset);
        })->has('portfolio')->take(10)->get();

        $other_profiles = [];
        if($others){
            foreach($others as $user){
                $other = $user->profile()->isPublic()->get()->first();
                if($other){
                    $other_profiles[] = fractal()->item($other)
                            ->transformWith(new ProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
                }
            }
        }

        $instagram = $user->instagram()->first();

        return view('profile.profile-about')->with([
            'profile' => $profile,
            'instagram' => $instagram,
            'name'  => $user->name,
            'others' => $other_profiles
        ]);
    }

    public function instagram(Request $request, User $user)
    {
        $token = $user->instagram()->first();
        $profile = $user->profile()->get()->first();
        $skills = $user->skills()->get();
        $others = User::where('id', '!=', $user->id)->whereHas('skills', function($query) use ($skills){
            $skillset = [];
            foreach($skills as $skill){
                $skillset[] = $skill->skill;
            }
            $query->whereIn('skill', $skillset);
        })->has('portfolio')->take(10)->get();

        $other_profiles = [];
        if($others){
            foreach($others as $user){
                $other = $user->profile()->isPublic()->get()->first();
                if($other){
                    $other_profiles[] = fractal()->item($other)
                            ->transformWith(new ProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
                }
            }
        }

        return view('profile.profile-instagram')->with([
                    'instaUser'  => $token,
                    'name'  => $user->name,
                    'profile' => $profile,
                    'others' => $other_profiles
                ]);
    }

    public function instagramFeed(Request $request, User $user, InstagramService $instagram)
    {
        $token = $user->instagram()->first();
        $media = $instagram->getUserRecentMedia($token['access_token']);
        
        if($media->meta->code === 200){
            return response()->json($media->data);
        } else {
            return response()->json($media);
        }
    }
    
}
