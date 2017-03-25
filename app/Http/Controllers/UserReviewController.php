<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReviewController extends Controller
{
    public function reviews(User $user)
    {
    	$reviews = $user->reviews()->latestFirst()->get();
    	return response()->json($reviews, 200);
    }

    public function submitReview(Request $request, User $user)
    {
    	$review = $user->reviews()->create([
    		'reviewer_id'	=> Auth::user()->id,
    		'score'			=> ($request->score) ? $request->score : 0,
    		'review'		=> $request->review
    	]);

    	return response()->json($review, 200);
    }
}
