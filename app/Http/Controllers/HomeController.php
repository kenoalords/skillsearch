<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use App\Models\User;
use App\Models\VerifyUser;
use App\Models\Profile;
use App\Models\Blog;
use App\Models\City;
use App\Models\Skills;
use App\Models\ContactInvite;
use App\Models\Subscriber;
use App\Models\Portfolio;
use App\Mail\ResendVerificationMail;
use App\Mail\ContactInviteBroadcast;
use App\Mail\EmailBroadcast;
use App\Http\Requests\UserProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Resource\Collection;
use App\Transformers\FollowersTransformer;
use App\Jobs\UserImageJob;
use App\Models\UserTracker;
use App\Transformers\ProfileTransformers;
use App\Transformers\PortfolioTransformer;
use App\Transformers\UserTransformers;
use App\Transformers\SimpleUserTransformers;
use App\Transformers\SimplePortfolioTransformer;
use App\Transformers\BlogTransformer;
use App\Models\EmailTracker;

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
    public function index(Request $request, ContactInvite $invite, Portfolio $portfolio, User $user, Subscriber $subscriber, UserTracker $tracker, Blog $blog)
    {
        // Get the logged in user
        $user = fractal()->item($request->user())
                    ->transformWith(new UserTransformers)
                    ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                    ->toArray();

        // Let's get some stats
        $works = $portfolio->where('user_id', '!=', $user['id'])->whereNotNull('thumbnail')->isPublic()->isFeaturedFirst();
        // if ( !empty($user['skills']) ){
        //     $skills = collect($user['skills'])->pluck('skill')->toArray();
        //     $interest = UserTracker::where(['user_id' => $user['id'], 'trackable_type' => 'App\Models\Portfolio'])->groupBy('tags')->pluck('tags')->toArray();
        //     $interests = collect(array_merge($skills, []))->unique()->toArray();
        //     $works = $portfolio->where('user_id', '!=', $user['id'])
        //                        ->whereIn('skills',  $interests)
        //                        ->whereNotNull('thumbnail')
        //                        ->inRandomOrder()
        //                        ->isPublic();
        // } else {
        //     $works = $portfolio->where('user_id', '!=', $user['id'])->isFeatured()->isPublic()->inRandomOrder();
        // }
        $blog = $blog->where('user_id', '!=', $user['id'])->isPublished()->latestFirst();

        // 1. Check if user has a gmail account
        // 2. Ask them to invite their contact
        $inviteStatus = true;
        $email = $request->user()->email;
        $gmailCheck =  preg_match('/(@gmail.com)$/', $email); 

        if($gmailCheck){
            $hasInvited = $invite->where('invitee_email', $email)->get();
            if($hasInvited->count()){
                $inviteStatus = true;
            } else {
                $inviteStatus = false;
            }
        }

        $following = $request->user()->followers()->pluck('following_id')->toArray();

        $to_follow = DB::table('users')
                            ->join('profiles', function($join){
                                $join->on('profiles.user_id', '=', 'users.id')
                                    ->whereNotNull('profiles.avatar');
                            })
                            ->where('users.id', '!=', $user['id'])
                            ->whereNotIn('users.id', $following)
                            ->select('users.id', 'users.name', 'profiles.first_name', 'profiles.last_name', 'profiles.avatar')
                            ->inRandomOrder()
                            ->take(50)
                            ->get();
        // dd($to_follow->all());

        $portfolios = fractal()->collection($works->take(20)->get())
                        ->transformWith(new SimplePortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();

        $blogs = fractal()->collection($blog->take(20)->get())
                        ->transformWith(new BlogTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();

        return view('home')->with([
            'gmail'             => (bool)$gmailCheck,
            'invite_status'     => $inviteStatus,
            'user'              => $user,
            'portfolios'        => $portfolios,
            'blogs'             => $blogs,
            'suggestions'       => $to_follow,
        ]);
    }

    public function getPortfolios($limit=16, $offset=0)
    {
        $following = Auth::user()->followers()->pluck('following_id')->all();
        return Portfolio::whereIn('user_id', $following)->orderBy('created_at', 'desc')->isPublic()->skip($offset)->take($limit)->get();
    }

    public function loadActivitiesAjax(Request $request)
    {
        $offset = (int)$request->page * (int)$request->limit;
        $portfolios = $this->getPortfolios((int)$request->limit, $offset);
        $portfolios = fractal()->collection($portfolios)
                            ->transformWith(new PortfolioTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        if($portfolios){
            $data = '';
            foreach($portfolios as $key => $portfolio){
                $data .= view('includes.portfolio-with-user', ['portfolio'=>$portfolio])->render();
            }
            return response()->json(['html'=>$data], 200);
        } else {
            return response()->json(false, 422);
        }
    }

    public function verify(Request $request){
        if(!Auth::user()){
            return redirect()->route('home');
        }
        
        $profile = Auth::user()->profile;
        if($profile->verified_email === 1)
            return redirect('/dashboard');
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
            return redirect('/dashboard');
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
            return redirect('/dashboard')->with('status', 'Your account is now verified');
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
        $url = $profile->getUserBackground();
        return response()->json($url, 200);
    }

    public function emailBroadcast(Request $request, User $users)
    {
        $this->authorize('is_admin', $request->user());
        if ( $request->isMethod('get') )
            return view('admin.email-broadcast');

        if ( $request->isMethod('post') ){
            $users = $users->all();
            $subject = $request->subject;
            $body = $request->body;
            $sender = $request->sender;
            // $image_link = $request->image_link;
            $url = ($request->url) ? $request->url : '';
            $text = ($request->text) ? $request->text : 'Learn more';
            if($users){
                foreach ($users as $key => $user){
                    Mail::to($user->email)->send(new EmailBroadcast($user, $subject, $body, $url, $text, $sender));
                }
                if ( $request->invitees == 'true' ){
                    $invites = ContactInvite::all();
                    foreach ( $invites as $invite ){
                        Mail::to($invite->email)->send(new ContactInviteBroadcast($subject, $body, $url, $text, $invite->email, $sender));
                    }
                }
                if ( $request->ajax() ){
                    return response()->json(true, 200);
                } else {
                    $request->session()->put('status', 'Bon voyage!! Email broadcast sent');
                    return redirect('/dashboard');
                }
            }
        }
    }

    public function trackEmail(Request $request, EmailTracker $tracker){
        $email = $request->query('email');
        $subject = $request->query('subject');
        $ip = $request->ip();
        $record = $tracker->create([
            'email'     => $email,
            'subject'   => $subject,
            'ip'        => $ip,
        ]);
        if ( $record ){
            return response(readfile( storage_path( '/app/public/email.jpg' ) ))->header('Content-Type', 'image/jpg');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    
}



