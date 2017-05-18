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
    		'reply_id'	=> $request->get('id', null),
    	]);


        if($request->get('id') == ''){
            if($portfolio->user_id !== $request->user()->id){
                Mail::to( $portfolio->user )->send(new CommentNotification( $portfolio->id, $request->user()->id, $request->get('id', null) ));
            }
        } else {
            $parent_comment = Comment::where('id', $request->get('id'))->first();
            $user = User::where('id', $parent_comment->user_id)->first();
            Mail::to( $user )->send(new CommentReplyNotification( $portfolio, $request->user()->id, $user ) );
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
