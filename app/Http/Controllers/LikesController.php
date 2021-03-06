<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\Like;
use App\Models\Portfolio;
use App\Services\PointService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\PortfolioLikeNotification;

class LikesController extends Controller
{
    public function get(Portfolio $portfolio)
    {
    	$response = [
    		'count'		=> $portfolio->likes()->count(),
    		'canLike'	=> false,
    		'hasLiked'	=> false,
    	];

    	if(Auth::user()){
    		$response = array_merge($response, [
    			'hasLiked'	=> $portfolio->userHasLiked(),
    		]);
    	}

    	return response()->json($response, 200);
    }

    public function add(Request $request, Portfolio $portfolio, PointService $pointService)
    {
    	// dd($portfolio);
    	$portfolio->likes()->create([
    		'user_id'		=> $request->user()->id,
    		'likeable_id'	=> $portfolio->id
    	]);
        $pointService->addPoint($request->user(), 'like');

        Mail::to($portfolio->user)->queue(new PortfolioLikeNotification($request->user(), $portfolio));
    	return response()->json(null, 200);
    }

    public function remove(Request $request, Portfolio $portfolio, PointService $pointService)
    {
    	// dd($portfolio);
    	$portfolio->likes()->where([
    		'user_id'		=> $request->user()->id,
    		'likeable_id'	=> $portfolio->id
    	])->delete();
        $pointService->deletePoint($request->user(), 'like');
    	return response()->json(null, 200);
    }
}
