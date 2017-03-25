<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;

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
    		return redirect()->to('/home');


    	} else {
    		$name = $social->getName();
    		$username = str_replace( '-', '', str_slug( $name ) );
    		if(User::where('name', $username)->get()->count()){
    			$username = uniqid(true);
    		}
    		// insert a new user record
    		$user = User::create([
    					'name'		=> $username,
    					'email'		=> $social->getEmail(),
    					'password' 	=> bcrypt(uniqid(true)),
    				]);
    		if($user){
    			$user->social()->create([
    				'provider_user_id' 	=> $social->getId(),
    				'provider'			=> 'google'
    			]);
    			Auth::login($user, true);
    			return redirect()->to('/home/start')->with(['name' => $username, 'fullname' => $name ]);
    		}

    	}

        // $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        // auth()->login($user);
        // return redirect()->to('/home');
    }
}
