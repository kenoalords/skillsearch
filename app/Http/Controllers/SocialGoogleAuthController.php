<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserRegistrationNotification;

class SocialGoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();   
    }   

    public function callback()
    {
    	$social = Socialite::driver('google')->user();

    	// dd($social->user);

    	$account = SocialAccount::where([
    					'provider_user_id' 	=> $social->getId(),
    					'provider'			=> 'google'
    				])->first();
    	
    	if($account){

    		Auth::loginUsingId($account->user_id, true);
    		return redirect()->to('/dashboard');


    	} else {
            $email = $social->getEmail();
            $name = $social->getName();
            $social_id = $social->getId();
            $provider = 'google';
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

        		$username = preg_replace('/(\s+)/', '_', $name);
                $username =  str_replace( '-', '_', str_slug( $username ) );
        		if(User::where('name', $username)->get()->count()){
        			$username = $username. mt_rand(100, 1000);
        		}
        		// insert a new user record
        		$user = User::create([
        					'name'		=> strtolower($username),
        					'email'		=> $email,
        					'password' 	=> bcrypt(uniqid(true)),
        				]);
        		if($user){
        			$user->social()->create([
        				'provider_user_id' 	=> $social_id,
        				'provider'			=> 'google'
        			]);
                    Mail::to($user)->queue(new UserRegistrationNotification($name));
        			Auth::login($user, true);
        			return redirect()->to('/dashboard/start')->with(['name' => $username, 'fullname' => $name ]);
        		}
            }

    	}

        // $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        // auth()->login($user);
        // return redirect()->to('/home');
    }
}
