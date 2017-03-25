<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;

class SocialTwitterAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('twitter')->redirect();   
    }   

    public function callback()
    {
    	$social = Socialite::driver('twitter')->user();

    	dd($social);

    	$account = SocialAccount::where([
    					'provider_user_id' 	=> $social->getId(),
    					'provider'			=> 'twitter'
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
    		SocialAccount::create([
    			'provider_user_id' 	=> $social->getId(),
    			'provider'			=> 'twitter',
    			'url'				=> $social->user->url,
    			'avatar'			=> $social->avatar_original,
    		]);
    		$user = User::create([
    					'name'		=> $username,
    					'email'		=> $social->getEmail(),
    					'password' 	=> bcrypt(uniqid(true)),
    				]);
    		if($user){
    			$user->social()->create([
    				
    			]);
    			Auth::login($user, true);
    			
    		}

    	}

        // $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        // auth()->login($user);
        // return redirect()->to('/home');
    }
}
