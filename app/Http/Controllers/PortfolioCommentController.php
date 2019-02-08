<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\Comment;
use App\Models\Portfolio;
use App\Mail\CommentNotification;
use App\Mail\CommentReplyNotification;
use App\Services\PointService;
use Illuminate\Http\Request;
use App\Transformers\CommentTransformer;
use App\Http\Requests\CommentFormRequest;
use App\Events\CommentPostedEvent;
use App\Notifications\PortfolioCommentNotification;
use App\Notifications\PortfolioCommentReplyNotification;

class PortfolioCommentController extends Controller
{
    public function index(Portfolio $portfolio)
    {
    	return response()->json(
    		fractal()->collection($portfolio->comments()->latestFirst()->get())
    				->transformWith(new CommentTransformer)
    				->toArray()
    	);
    }

    public function addComment(CommentFormRequest $request, Portfolio $portfolio, PointService $pointService)
    {
    	$comment = $portfolio->comment()->create([
    		'user_id'	=> $request->user()->id,
    		'comment'	=> $request->comment,
    		'reply_id'	=> ($request->id) ? $request->id : null,
    	]);

        if(!$request->id){
            if ( $portfolio->user->id !== $request->user()->id ){
                $portfolio->user
                ->notify(new PortfolioCommentNotification( $portfolio, $request->user()->profile->first_name ));
            }
        } else {
            $old_comment = Comment::where('id', $request->id)->first();
            if ( $old_comment->user->id !== $request->user()->id )
                $old_comment->user->notify(new PortfolioCommentReplyNotification( $portfolio, $request->user()->profile->first_name ));
        }

        // Add Point For Comment
        if($portfolio->user_id !== $request->user()->id){
            $pointService->addPoint($request->user(), 'comment');
        }



    	return response()->json(
    		fractal()->item($comment)
    				->transformWith(new CommentTransformer)
    				->toArray()
    	);
    }
}
