<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();   
    }   

    public function callback()
    {
    	$social = Socialite::driver('facebook')->user();

    	// dd($social->getEmail());

    	$account = SocialAccount::where([
    					'provider_user_id' 	=> $social->getId(),
    					'provider'			=> 'facebook'
    				])->first();
    	
    	if($account){

    		// auth()->login($account->user);
    		Auth::loginUsingId($account->user_id, true);
    		return redirect()->to('/home');


    	} else {
            $name = $social->getName();
            $username = str_replace( '-', '', str_slug( $name ) );
            if(User::where('name', $username)->get()){
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
    				'provider'			=> 'facebook'
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
