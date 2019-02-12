<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PointService;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FollowUserNotification;
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

    public function addFollower(Request $request, User $user, PointService $point)
    {
    	Auth::user()->followers()->create([
    		'following_id'	=> $user->id
    	]);
        $point->addPoint(Auth::user(), 'follow');
        $user->notify(new FollowUserNotification($request->user()->profile->first_name, $request->user()->name ));
    	return response()->json(true, 200);
    }

    public function deleteFollower(Request $request, User $user, PointService $point)
    {
    	Auth::user()->followers()->where('following_id', $user->id)->delete();
        $point->deletePoint(Auth::user(), 'follow');
    	return response()->json(null, 200);
    }
}
