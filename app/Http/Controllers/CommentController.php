<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Services\PointService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function likeComment( Request $request, PointService $point, Comment $comment )
    {
    	$hasLiked = $comment->likes()->where('user_id', $request->user()->id)->first();
    	if ( $comment && !$hasLiked ) {
    		$comment->likes()->create([
    			'user_id'		=> $request->user()->id,
    			'likeable_id'	=> $request->comment_id,
    		]);
    		$point->addPoint($request->user(), 'comment_like');
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
