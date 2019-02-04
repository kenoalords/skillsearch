<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Category;
use App\Models\Subscriber;
use App\Models\SocialShare;
use App\Models\Comment;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Jobs\UserImageJob;
use App\Traits\Orderable;
use App\Transformers\BlogTransformer;
use App\Transformers\CommentTransformer;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Transformers\EditBlogTransformer;
use Facades\App\Repository\Blogs;
use Carbon\Carbon;
use App\Mail\BlogLikeNotification;
use App\Mail\BlogSubscriptionNotification;
use App\Mail\BlogCommentNotification;
use App\Mail\BlogCommentReplyNotification;
use App\Mail\BlogCommentLikeNotification;
use App\Http\ViewComposers\ReadMoreBlogComposer;
use Mail;

class BlogController extends Controller
{
    use Orderable;

    public function userBlog(Request $request)
    {
        $blogs = $request->user()->blog()->latestFirst()->get();
        $payload = fractal()->collection($blogs)
                        ->transformWith(new BlogTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        return view('blog.user-blog')->with(['blogs'=>$payload]);
    }

    public static function uploadBlogImage(Request $request){
        $file = $request->file('image')->store('public');
        Image::make(storage_path( '/app/'.$file ))->resize('1024', null, function($const){
            $const->aspectRatio();
        })->save();
        return $file;
    }

    public function editBlogPost(Request $request, Blog $blog, Category $categories)
    {
        // Handle GET request
        if ( $request->isMethod('get') ){
            $categories = $categories->orderAsc()->get();
            $blog = fractal()->item($blog)
                        ->transformWith(new EditBlogTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
            return view('blog.edit')->with(['user' => $request->user()->profile, 'categories' => $categories, 'blog' => $blog]);
        }

        // Handle PUT request
        if ( $request->getMethod('put') ){

            // Check if a new file was uploaded
            if ( $request->hasFile('image') ){               
                $image_url = BlogController::uploadBlogImage($request);
            } else {
                $image_url = $request->image;
            }

            $blog->title = $request->title;
            $blog->body = clean( $request->body );
            $blog->category = $request->category;
            $blog->excerpt = $request->excerpt;
            $blog->tags = $request->tags;
            $blog->slug = str_slug($request->title);
            $blog->image = $image_url;
            $blog->allow_comments = ($request->allow_comments === "true") ? 1 : 0;
            $blog->save();

            $cache_key = Blogs::getCacheKey($blog->uid);
            if ( cache()->has($cache_key) ){
                cache()->forget($cache_key);
            }

            cache()->remember($cache_key, Carbon::now()->addMonths(6), function() use($blog) {
                return Blogs::transformItem($blog);
            });

            if ( $request->ajax() ){
                return response()->json(true, 200);
            }
        } 
    }

    public function deleteBlog(Request $request, Blog $blog){
        if ($request->isMethod('delete')){
            $blog->delete();
            return response()->json(true, 200);
        }
    }

    public function handleBlogForm(Request $request, Category $categories)
    {
        // Handle the get request and show the form
        if ( $request->isMethod('get') ){
            $categories = $categories->orderAsc()->get();
            return view('blog.add')->with(['user' => $request->user()->profile, 'categories' => $categories]);
        }

        // Handle the post request when a user submits a blog post
        if ( $request->isMethod('post') ){
            // dd($request->input());
            $image_url = null;
            if ( $request->hasFile('image') ){               
                $image_url = BlogController::uploadBlogImage($request);
            }
            
            $title = ($request->title) ? $request->title : 'Draft';
            $body = $request->body;
            $uid = uniqid(true);
            $blog = $request->user()->blog()->create([
                'title'         => $title,
                'body'          => clean( $body ),
                'slug'          => str_slug($title),
                'category'      => $request->category,
                'excerpt'       => $request->excerpt,
                'tags'          => $request->tags,
                'uid'           => $uid,
                'allow_comments'=> ($request->allow_comments === "true") ? 1 : 0,
                'image'         => $image_url,
                'is_public'     => (bool)$request->is_public,
                'status'        => $request->status,
            ]);
            $cache_key = Blogs::getCacheKey($blog->uid);
            $blog = fractal()->item($blog)
                            ->transformWith(new BlogTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
            cache()->remember($cache_key, Carbon::now()->addWeek(), function() use($blog){
                return $blog;
            });
            return response()->json($blog, 200);
        }
    	
    }

    

    public function subscribeRegisteredUser(Request $request, Blog $blog)
    {
        if($request->user()->id === $blog->user_id){
            return response()->json(['status'=>'owner'], 200);
        } else {
            // $user = $user->where('id', $blog->user_id)->first();
            $check = Subscriber::where(['user_id'=>$blog->user->id, 'subscriber_id'=>$request->user()->id])->first();
            if(!$check){
                // dd($request);
                $subscribe = $blog->user->subscriber()->create([
                            'subscriber_id' => $request->user()->id,
                            'fullname'      => $request->user()->profile->fullname,
                            'email'         => $request->user()->email,
                            'blog_id'       => $request->blog_id,
                            'blog_title'    => $request->blog_title,
                            'blog_url'      => $request->blog_url,
                            'ip'            => $request->ip(),
                        ]);
                if($subscribe){
                    Mail::to($blog->user)->send(new BlogSubscriptionNotification($blog));
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
                'email'     => 'required|email',
            ]);
        $subscribe = $blog->user->subscriber()->create([
                'fullname'  => ucwords(strtolower($request->fullname)),
                'email'     => strtolower($request->email),
                'ip'        => $request->ip(),
                'blog_title'=> $request->title,
                'blog_url'  => $request->blog_url,
                'blog_id'   => $request->blog_id,
            ]);
        if($subscribe){
            $count = $blog->user->subscriber()->count();
            Mail::to($blog->user)->send(new BlogSubscriptionNotification($blog));
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
        $ID = $blog->id;
        if($check){
            $count = $blog->likes()->count();
            return response()->json(['count'=>$count], 200);
        } else {
            $like = $blog->likes()->create([
                    'user_id'   => $userID
                ]);
            if($like){
                $count = $blog->likes()->count();
                if ( $request->user()->id !== $blog->user->id ){
                    Mail::to($blog->user)->send(new BlogLikeNotification($request->user()->profile->first_name, $ID, $count));
                }
                return response()->json(['count'=>$count], 200);
            }
        }
    }

    public function commentCount(Request $request, Blog $blog){
        $comments = $blog->comments()->where('reply_id', null)->latestFirst()->get();
        $payload = fractal()->collection($comments)
                    ->transformWith(new CommentTransformer)
                    ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                    ->toArray();

        if ( $request->ajax() ){
            return response()->json([ 'count'=> $comments->count(), 'comments' => $payload ]);
        }
    }

    public function submitComment(Request $request, Blog $blog){
        $comment = $blog->comments()->create([
            'user_id'   => $request->user()->id,
            'comment'   => $request->comment,
        ]);
        $payload = fractal()->item($comment)
                    ->transformWith(new CommentTransformer)
                    ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                    ->toArray();
        if ( $request->user()->id !== $blog->user->id ){
            Mail::to($blog->user)->send(new BlogCommentNotification($blog, $request->user(), $comment));
        }
        if ( $request->ajax() ){
            return response()->json($payload, 200);
        }
    }

    public function submitCommentReply(Request $request, Blog $blog){
        $this->validate($request, [
            'reply'     => 'required|string',
            'comment_id'=> 'required|numeric'
        ]);
        $reply = $blog->comments()->create([
            'user_id'   => $request->user()->id,
            'reply_id'  => $request->comment_id,
            'comment'   => $request->reply,
        ]);
        $payload = fractal()->item($reply)
                        ->transformWith(new CommentTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        if ( $request->ajax() ){
            $comment = Comment::where('id', $request->comment_id)->first();
            Mail::to($comment->user)->send(new BlogCommentReplyNotification($comment, $request->user(), $reply, $blog));
            return response()->json($payload, 200);
        }
    }

    public function viewBlogPost(Request $request, User $user, Blog $blog){
        // dd($blog);
        $start_time = microtime(true);
        $log_view = $blog->views()->create([ 'ip'=> $request->ip()]);
        $blog = Blogs::get($blog);
        $duration = floor((microtime(true) - $start_time) * 1000);
        $data = ['id'=>$blog['id']];
        $others = fractal()->collection(Blog::whereNotIn('id', [$blog['id']])->isPublished()->take(3)->get())
                        ->transformWith(new BlogTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        return view('blog.single')->with([ 'blog'=>$blog, 'duration'=>$duration, 'others' => $others ]);
    }

    public function trackSocialShares(Request $request, SocialShare $share){
        if ( $request->ajax() ){
            $log = $share->create([
                        'network'   => $request->network,
                        'url'       => $request->url,
                        'agent'     => $request->agent,
                        'ip'        => $request->ip(),
                    ]);
            if ( $log ){
                return response()->json(true, 200);
            }

        } else {
            return false;
        }
    }

    public function subscribers(Request $request){
        $subscribers = $request->user()->subscriber()->get();
        return view('blog.subscribers')->with(['subscribers'=>$subscribers]);
    }

    public function imageUpload(Request $request){
        if ( $request->isMethod('post') ){
            if ( $request->hasFile('image') ){
                $file = $request->file('image')->store('public');
                Image::make(storage_path( '/app/'.$file ))->resize('760', null, function($const){
                    $const->aspectRatio();
                })->save();
                return response()->json([ 'url'=> asset($file) ]);
            }
        }
    }

    public function countBlogLike(Request $request, Blog $blog)
    {
        $count = $blog->likes()->count();
        return response()->json($count, 200);
    }

    public function submitCommentLike(Request $request, Blog $blog, Comment $comment)
    {
        $check = $comment->likes()->where([ 'user_id' => $request->user()->id ])->first();
        if ( $check ){
            return response()->json(['status'=> 'liked'], 200);
        } else {
            $insert = $comment->likes()->create([
                        'user_id' => $request->user()->id,
                    ]);
            if ( $insert ){
                $count = $comment->likes()->count();
                if ( $comment->user->id !== $request->user()->id ){
                    Mail::to($comment->user)->send(new BlogCommentLikeNotification($blog, $comment, $request->user()));
                }
                return response()->json(['status'=>true, 'count'=>$count], 200);
            }
        }
    }
}
