<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
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

    public function addComment(CommentFormRequest $request, Portfolio $portfolio)
    {
    	$comment = $portfolio->comment()->create([
    		'user_id'	=> $request->user()->id,
    		'comment'	=> $request->comment,
    		'reply_id'	=> $request->get('id', null),
    	]);
    	return response()->json(
    		fractal()->item($comment)
    				->transformWith(new CommentTransformer)
    				->toArray()
    	);
    }
}
