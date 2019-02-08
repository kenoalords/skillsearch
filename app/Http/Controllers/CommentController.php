<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Portfolio;
use App\Models\Like;
use App\Models\User;
use App\Services\PointService;
use Illuminate\Http\Request;
use App\Notifications\PortfolioCommentLikeNotification;

class CommentController extends Controller
{

    public function get(Request $request)
    {
        
    }

    public function likeComment( Request $request, PointService $point, Comment $comment )
    {
    	$hasLiked = $comment->likes()->where('user_id', $request->user()->id)->first();
    	if ( $comment && !$hasLiked ) {
    		$comment->likes()->create([
    			'user_id'		=> $request->user()->id,
    			'likeable_id'	=> $request->comment_id,
    		]);
    		$point->addPoint($request->user(), 'comment_like');
            $portfolio = Portfolio::where('id', $comment->commentable_id)->first();
            $comment->user->notify(new PortfolioCommentLikeNotification($comment, $portfolio, $request->user()->profile->first_name));
    		return response()->json([
    				'likes'	=> $comment->likes()->count()
    			]);
    	} elseif ( $comment && $hasLiked ) {
    		$hasLiked->delete();
    		$point->deletePoint($request->user(), 'comment_like');
    		return response()->json([
    				'likes'	=> $comment->likes()->count()
    			]);
    	}
    }

    public function deleteComment(Request $request, Comment $comment)
    {
    	$this->authorize('delete', $comment);
    	$comment->delete();
    	return response()->json([
    			'deleted'	=> true
    		]);
    }
}
