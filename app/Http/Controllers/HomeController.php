<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\VerifyUser;
use App\Models\Profile;
use App\Models\Task;
use App\Models\City;
use App\Models\Skills;
use App\Models\Activity;
use App\Models\ContactInvite;
use App\Models\Instagram;
use App\Models\Portfolio;
use App\Mail\ResendVerificationMail;
use App\Mail\EmailBroadcast;
use App\Http\Requests\UserProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Resource\Collection;
use App\Transformers\FollowersTransformer;
use App\Jobs\UserImageJob;
use App\Transformers\ProfileTransformers;
use App\Transformers\PortfolioTransformer;
use App\Transformers\UserTransformers;
use App\Transformers\SimpleUserTransformers;
use App\Transformers\TaskTransformer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ContactInvite $invite, Portfolio $portfolio, User $user, Task $task)
    {   
        $following = $request->user()->followers()->pluck('following_id')->all();
        $portfolios = $portfolio->whereIn('user_id', $following)->orderBy('created_at', 'desc')->limit(2)->get();
        $user_profile = $request->user()->profile()->first();
        
        $activities = fractal()->collection($portfolios)
                                ->transformWith(new PortfolioTransformer)
                                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                ->toArray();
        // dd($activities);
        $tasks = fractal()->collection($tasks = $task->isPublic()->isApproved()->orderDesc()->take(5)->get())
                          ->transformWith(new TaskTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        $people = null;
        if(!$activities){
            $defaults = [
                'location'  => '%Lagos',
            ];

            $collection = $user->where('id', '!=', $request->user()->id)->has('portfolio')->withCount(['portfolio' => function($query){
                                $query->where('is_public', true);
                            }])->orderBy('portfolio_count', 'desc')->take(10)->get();
            $people = fractal()->collection($collection)
                            ->transformWith(new UserTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        }

        $email = $request->user()->email;
        $inviteStatus = true;
        $gmailCheck =  preg_match('/(@gmail.com)$/', $email); //$request->user()->email

        if($gmailCheck){
            $hasInvited = $invite->where('invitee_email', $email)->get();
            if($hasInvited->count()){
                $inviteStatus = true;
            } else {
                $inviteStatus = false;
            }
        }
        $user = fractal()->item($user_profile)
                            ->transformWith(new ProfileTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();



        return view('home')->with([
            'user'      => $user,
            'activities'=> $activities,
            'gmail'     => (bool)$gmailCheck,
            'invite_status' => $inviteStatus,
            'profiles'  => $people, 
            'tasks'     => $tasks,
        ]);
    }


    public function verify(Request $request){
        if(!Auth::user()){
            return redirect()->route('home');
        }
        
        $profile = Auth::user()->profile;
        if($profile->verified_email === 1)
            return redirect('/home');
        else
            return view('verify')->with(['profile' => $profile]);
    }

    public function resendVerify(Request $request)
    {
        if(!Auth::user()){
            return redirect()->route('home');
        }

        $user = $request->user();
        $key = VerifyUser::where('user_id', $user->id)->first();
        // dd($key->verify_key);
        if(!$key){
            return redirect('/home');
        }
        Mail::to($user)->send(new ResendVerificationMail($user->name, $key->verify_key));
        return redirect()->route('verify')->with('status', 'A new verification email is on its way!');
    }

    public function verifyUser(Request $request, VerifyUser $verify, Profile $profile){
        $user = $verify->where('verify_key', $request->verify_key)->get()->first();

        if($user->count()){
            $verify_profile = $profile->where('user_id', $user->user_id)->get()->first();

            $verify_profile->verified_email = 1;
            $verify_profile->save();
            $user->delete();
            return redirect('/home')->with('status', 'Your account is now verified');
        }
    }

    public function getCities(Request $request, City $city){

        return $city->where('city', 'like', $request->cities.'%')->join('states', 'states.id', '=', 'cities.state_id')->get();

    }

    public function getSkills(Skills $skills){
        return $skills->unselectedSkills()->orderAlphabetically()->get();
    }

    public function getUserSkills(Request $request, Skills $skills){
        return $request->user()->skills()->get();
    }

    // Setup new account
    public function start(Request $request){

        $user = $request->user();
        $profile = $request->user()->profile;
        return view('profile.start')->with(['user' => $user, 'profile' => $profile ]);
    }

    public function submitPersonalInformation(UserProfileRequest $request){
        // dd($request);

        $request->user()->profile()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender'    => $request->gender,
            'account_type'=> $request->account_type
        ]);

        return redirect()->route('personal_info');
    }

    public function personalInfo(Request $request, Skills $skill){
        $user = $request->user();
        $profile = $request->user()->profile;
        $skills = $skill->get();

        return view('profile.bio-skills')->with(['user' => $user, 'profile' => $profile, 'skills' => $skills ]);
    }

    public function savePersonalInfo(Request $request, Skills $skill){
        $user = $request->user();
        $profile = $request->user()->profile;
        $skills = $skill->get();

        $this->validate($request, [
            'bio' => 'required'
        ]);

        $profile->bio = $request->bio;
        $profile->save();

        return view('profile.bio-skills')->with(['user' => $user, 'profile' => $profile, 'skills' => $skills ]);
    }

    public function addUserSkill(Request $request){
        // dd($request);
        $request->user()->skills()->create([
            'user_id'   => $request->user()->id,
            'skill'     => $request->skill,
            'skills_id' => $request->id
        ]);
    }

    public function deleteUserSkill(Request $request){
        $request->user()->skills()->where('skill', '=', $request->skill)->delete();
    }

    public function uploadBackgroundImage(Request $request)
    {
        $this->validate($request, [
            'file'  => 'image'
        ]);
        $profile = $request->user()->profile()->get()->first();
        if($profile->background){
            Storage::delete($profile->background);
        }
        $image = $request->file('file')->store('public');
        $profile->background = $image;
        $profile->save();
        dispatch(new UserImageJob($image));

        return response()->json($image, 200);
    }

    public function membersEmailBroadcast(Request $request)
    {
        $this->authorize('is_admin', $request->user());
        return view('admin.email-broadcast');
    }

    public function submitEmailBroadcast(Request $request, User $users)
    {
        $this->authorize('is_admin', $request->user());
        $users = $users->all();
        $subject = $request->subject;
        $body = $request->body;
        $image_link = $request->image_link;
        $url = ($request->url) ? $request->url : '';
        $button_text = ($request->button_text) ? $request->button_text : 'Learn more';
        if($users){
            foreach ($users as $key => $user){
                Mail::to($user->email)->send(new EmailBroadcast($user, $subject, $body, $url, $button_text, $image_link));
            }
            $request->session()->put('status', 'Bon voyage!! Email broadcast sent');
            return redirect('/home');
        }
    }

}



