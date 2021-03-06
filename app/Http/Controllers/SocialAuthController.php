<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserRegistrationNotification;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();   
    }   

    public function callback()
    {
    	$social = Socialite::driver('facebook')->user();

    	// dd($social);

    	$account = SocialAccount::where([
    					'provider_user_id' 	=> $social->getId(),
    					'provider'			=> 'facebook'
    				])->first();
    	
    	if($account){

    		// auth()->login($account->user);
    		Auth::loginUsingId($account->user_id, true);
    		return redirect()->to('/home');


    	} else {
            $email = $social->getEmail();
            $name = $social->getName();
            $social_id = $social->getId();
            $provider = 'facebook';
            // dd($email);
            // Check is user has signed up before
            $user = User::where('email', $email)->first();
            
            if($user){
                // Yes! Have them confirm their password and link their social account
                return redirect()->route('merge_account', [
                    'name'      => $name,
                    'user'      => $user,
                    'email'     => $email,
                    'social_id' => $social_id,
                    'provider'  => $provider
                ]);
            } else {
                // Setup a new account for them on the site
                $username = str_replace( '-', '', str_slug( $name ) );
                if(User::where('name', $username)->get()){
                    $username = uniqid(true);
                }
                // insert a new user record
                $user = User::create([
                            'name'      => strtolower($username),
                            'email'     => $email,
                            'password'  => bcrypt(uniqid(true)),
                        ]);
                if($user){
                    $user->social()->create([
                        'provider_user_id'  => $social_id,
                        'provider'          => $provider
                    ]);
                    Mail::to($user)->queue(new UserRegistrationNotification($name));
                    Auth::login($user, true);
                    return redirect()->to('/home/start')->with(['name' => $username, 'fullname' => $name ]);
                }
            }
    	}

        // $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        // auth()->login($user);
        // return redirect()->to('/home');
    }
}
