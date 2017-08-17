<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Category;
use App\Models\Subscriber;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Jobs\UserImageJob;
use App\Traits\Orderable;
use App\Transformers\BlogTransformer;
use League\Fractal\Resource\Collection;

class BlogController extends Controller
{
    use Orderable;

    public function userBlog(Request $request)
    {
        $blogs = $request->user()->blog()->latestFirst()->get();
        $blogs = fractal()->collection($blogs)
                            ->transformWith(new BlogTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        // dd($blogs);                    
        return view('blog.user-blog')->with(['blogs'=>$blogs]);
    }

    public function singleBlog(Request $request, $string, Blog $blog)
    {
        $blog = fractal()->item($blog)
                            ->transformWith(new BlogTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        return view('blog.single')->with(['blog'=>$blog]);
    }
    
    public function addBlogPost(Request $request, Category $categories)
    {
        $categories = $categories->orderAsc()->get();
    	return view('blog.add')->with(['user' => $request->user()->profile, 'categories' => $categories]);
    }

    public function editBlogPost(Request $request, Blog $blog, Category $categories)
    {
        $categories = $categories->orderAsc()->get();
        $blog = fractal()->item($blog)
                            ->transformWith(new BlogTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        return view('blog.edit')->with(['user' => $request->user()->profile, 'categories' => $categories, 'blog' => $blog]);
    }

    public function submitBlogPost(Request $request)
    {
        // dd($request->id);
    	if($request->id){
    		$blog = $request->user()->blog()->where('id', $request->id)->update([
    			'title' => $request->title,
    			'body'	=> e($request->body),
    			'slug'	=> str_slug($request->title),
                'allow_comments'=> (bool)$request->allow_comments,
                'category'      => $request->category,
                'excerpt'      => $request->excerpt,
    		]);
            $blog = fractal()->item($blog)
                            ->transformWith(new BlogTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
    		return response()->json($blog, 200);
    	} else {
    		$title = ($request->title) ? $request->title : 'Draft';
    		$body = $request->body;
            $uid = uniqid(true);
            // dd($uid);
    		$blog = $request->user()->blog()->create([
    			'title'	        => $title,
    			'body'	        => e($body),
    			'slug'	        => str_slug($title),
                'category'      => $request->category,
                'excerpt'       => $request->excerpt,
                'uid'           => $uid,
                'allow_comments'=> (bool)$request->allow_comments,
    		]);
            $blog = fractal()->item($blog)
                            ->transformWith(new BlogTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
    		return response()->json($blog, 200);
    	}
    }

    public function submitBlogPostImage(Request $request)
    {
        // dd($request);
    	$this->validate($request, ['image' => 'image']);

    	$upload = $request->file('image')->store('public');
    	Image::make(storage_path() . '/app/' . $upload)->fit(1240,698, function($c){
    		$c->upsize();
    	})->save();

    	if($request->id !== 'undefined'){
    		$this->validate($request, ['id'=>'exists:blogs,id']);
    		$blog = $request->user()->blog()->where('id', $request->id)->first();
    		if($upload){
    			$blog->image = $upload;
    			$blog->save();
    			dispatch(new UserImageJob($upload));
    			return response()->json($blog, 200);
    		}
    	} else {
    		$title = ($request->title != 'undefined') ? $request->title : 'Draft';
    		$body = ($request->body != 'undefined') ? $request->body : 'Nothing yet';
    		$blog = $request->user()->blog()->create([
    			'title' => $title,
    			'slug'	=> str_slug($title),
    			'body'	=> e($body),
    			'image' => $upload,
                'uid'   => uniqid(true),
    		]);
    		dispatch(new UserImageJob($upload));
    		return response()->json($blog, 200);
    	}
    }

    public function subscribeRegisteredUser(Request $request, Blog $blog, User $user)
    {
        if($request->user()->id !== $blog->user_id){
            return response()->json(['status'=>'owner'], 200);
        } else {
            $user = $user->where('id', $blog->user_id)->first();
            $check = Subscriber::where(['user_id'=>$user->id, 'subscriber_id'=>$request->user()->id])->first();
            if(!$check){
                $subscribe = $user->subscriber()->create([
                            'subscriber_id' => $request->user()->id,
                            'fullname'      => $request->user()->profile->first_name,
                            'email'         => $request->user()->email,
                        ]);
                if($subscribe){
                    $count = $blog->user->subscriber()->count();
                    return response()->json(['status'=>'subscribed', 'count' => $count], 200);
                }
            } else {
                $check->delete();
                $count = $blog->user->subscriber()->count();
                return response()->json(['status'=>'unsubscribed', 'count' => $count], 200);
            }
        }
    }

    public function subscribeVisitor(Request $request, Blog $blog, User $user)
    {
        $this->validate($request, [
                'fullname'  => 'required|string',
                'email'     => 'required|email'
            ]);
        $subscribe = $blog->user->subscriber()->create([
                'fullname'  => ucwords($request->fullname),
                'email'     => strtolower($request->email),
            ]);
        if($subscribe){
            $count = $blog->user->subscriber()->count();
            return response()->json(['status'=>'subscribed', 'count' => $count], 200);
        }
    }

    public function checkBlogSubscription(Request $request, Blog $blog, Subscriber $subscriber)
    {
        $blog_owner = $blog->user->id;
        $check = $subscriber->where([
                'user_id'   => $blog_owner,
                'subscriber_id' => $request->user()->id,
            ])->first();
        if($check){
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function checkBlogLike(Request $request, Blog $blog)
    {
        $check = $blog->likes()->where('user_id', $request->user()->id)->first();
        if($check){
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function submitBlogLike(Request $request, Blog $blog)
    {
        $userID = $request->user()->id;
        $check = $blog->likes()->where('user_id', $userID)->first();
        if($check){
            $check->delete();
            $count = $blog->likes()->count();
            return response()->json(['count'=>$count], 200);
        } else {
            $like = $blog->likes()->create([
                    'user_id'   => $userID
                ]);
            if($like){
                $count = $blog->likes()->count();
                return response()->json(['count'=>$count], 200);
            }
        }
    }
}
