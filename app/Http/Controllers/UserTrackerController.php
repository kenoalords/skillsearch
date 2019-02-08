<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Blog;
use Illuminate\Http\Request;

class UserTrackerController extends Controller
{
	public function addPageActivity(Request $request, Blog $blog, Portfolio $portfolio)
	{
		if ( $request->cookie('_ub_') ){
			$uuid = $request->cookie('_ub_');
			if ( $request->type === 'blog' ){
				$blog->find($request->id)->track()->create([
					'uuid'	=> $request->cookie('_ub_'),
					'user_id'	=> ($request->user()) ? $request->user()->id : null,
					'url'	=> $request->url,
					'tags'	=> $request->tags,
					'ip'		=> $request->ip(),
					'user_agent' => $request->header('user-agent'),
				]);
			}
			if ( $request->type === 'portfolio' ){
				$portfolio->find($request->id)->track()->create([
					'uuid'	=> $request->cookie('_ub_'),
					'user_id'	=> ($request->user()) ? $request->user()->id : null,
					'url'	=> $request->url,
					'tags'	=> $request->tags,
					'ip'		=> $request->ip(),
					'user_agent' => $request->header('user-agent'),
				]);
			}
		} else {
			return response()->json(false, 200);
		}
	}
}
