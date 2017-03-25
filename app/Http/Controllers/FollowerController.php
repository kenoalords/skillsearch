<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class FollowerController extends Controller
{
    
    public function getFollowers(User $user)
    {
    	$response = [
    		'followers' => $user->getFollowers($user),
    		'following' => $user->getFollowing(),
    		'is_self'	=> false,
    		'can_follow' => true,
    	];

    	if(Auth::user()){
    		$response = array_merge($response, [
    			'is_self' => $user->userIsSelf(Auth::user()),
    			'can_follow' => Auth::user()->userCanFollow($user),
    		]);
    	}

    	return response()->json($response, 200);
    }

    public function addFollower(Request $request, User $user)
    {
    	Auth::user()->followers()->create([
    		'following_id'	=> $user->id
    	]);
    	return response()->json(null, 200);
    }

    public function deleteFollower(Request $request, User $user)
    {
    	Auth::user()->followers()->where('following_id', $user->id)->delete();
    	return response()->json(null, 200);
    }
}
