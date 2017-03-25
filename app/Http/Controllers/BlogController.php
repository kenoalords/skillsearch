<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Jobs\UserImageJob;

class BlogController extends Controller
{
    
    public function addBlogPost(Request $request)
    {
    	return view('blog.add')->with('user', $request->user()->profile);
    }

    public function submitBlogPost(Request $request)
    {
    	if($request->id != "null"){
    		$blog = $request->user()->blog()->where('id', $request->id)->update([
    			'title' => $request->title,
    			'body'	=> $request->body,
    			'slug'	=> str_slug($request->title)
    		]);
    		// $blog->title = $request->title;
    		// $blog->body = $request->body;
    		// $blog->slug = str_slug($request->title);
    		// $blog->save();
    		return response()->json($blog, 200);
    	} else {
    		$title = ($request->title !== "null") ? $request->title : 'Untitled Draft';
    		$body = ($request->body !== "null") ? $request->body : 'No body content yet';
    		$blog = $request->user()->blog()->create([
    			'title'	=> $title,
    			'body'	=> $body,
    			'slug'	=> str_slug($title),
    		]);
    		return response()->json($blog, 200);
    	}
    }

    public function submitBlogPostImage(Request $request)
    {
    	$this->validate($request, ['image' => 'image']);

    	$upload = $request->file('image')->store('public');
    	Image::make(storage_path() . '/app/' . $upload)->fit(750,300, function($c){
    		$c->upsize();
    	})->save();

    	if($request->id !== "null"){
    		$this->validate($request, ['id'=>'exists:blogs,id']);
    		$blog = $request->user()->blog()->where('id', $request->id)->get();
    		if($upload){
    			$blog->image = $upload;
    			$blog->save();
    			dispatch(new UserImageJob($upload));
    			return response()->json($blog, 200);
    		}
    	} else {
    		$title = ($request->title !== "null") ? $request->title : 'Untitled Draft';
    		$body = ($request->body !== "null") ? $request->body : 'No body content yet';
    		$blog = $request->user()->blog()->create([
    			'title' => $title,
    			'slug'	=> str_slug($title),
    			'body'	=> $body,
    			'image' => $upload
    		]);
    		dispatch(new UserImageJob($upload));
    		return response()->json($blog, 200);
    	}



    	// return response()->json($request->image, 200);
    }
}
