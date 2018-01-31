<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\File;
use App\Models\Skills;
use App\Models\Like;
use App\Services\PointService;
use Illuminate\Http\Request;
use App\Events\PortfolioImageUploadEvent;
use App\Events\PortfolioFilesUploadEvent;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Transformers\PortfolioTransformer;
use App\Transformers\SkillsTransformer;
use App\Transformers\SimpleUserTransformers;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Jobs\DeleteFileFromS3Storage;
use App\Jobs\UploadFileToS3;
use App\Jobs\FileDeleteJob;

// Mails
use App\Mail\FeaturedPortfolioNotification;

use App\Traits\Orderable;


class PortfolioController extends Controller
{
    use Orderable;
    // private $storage = Storage::disk('s3images');
    public function index(Request $request)
    {
        
        $portfolios = fractal()->collection($request->user()->portfolio()->latestFirst()->get())
                            ->transformWith(new PortfolioTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
    	return view('portfolio.portfolio')->with(
            [
                'portfolios'    => $portfolios,
            ]
        );
    }

    public function add(Request $request)
    {
        $skills = fractal()->collection($request->user()->skills()->get())
                        ->transformWith(new SkillsTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
    	return view('portfolio.add')->with(['skills' => $skills]);
    }

    public function edit(Request $request, Portfolio $portfolio)
    {
        $this->authorize('edit', $portfolio);
        $portfolio = fractal()->item($portfolio)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        $skills = fractal()->collection($request->user()->skills()->get())
                        ->transformWith(new SkillsTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
    	return view('portfolio.edit')->with([
    		'portfolio' => $portfolio,
            'skills'    => $skills,
    	]);
    }

    public function savePortfolio(Request $request, PointService $pointService)
    {
        if($request->uid !== "null"){
            $portfolio = $request->user()->portfolio()->where('uid', $request->uid)->first();
            $title = ($request->title !== "null") ? $request->title : 'Draft Portfolio';
            $description = ($request->description != "undefined") ? $request->description : '';
            $is_public = ($request->action === "publish") ? true : false;
            $portfolio->title = $title;
            $portfolio->description = $description;
            $portfolio->is_public = $is_public;
            $portfolio->skills = $request->skills;
            $portfolio->save();
            if($is_public){
                $pointService->addPoint($request->user(), 'upload_portfolio');
            }
            return response()->json(true);
        } else {
            $uid = uniqid(true);
            $title = ($request->title !== "null") ? $request->title : 'Draft Portfolio';
            $description = ($request->description != "undefined") ? $request->description : '';
            $is_public = ($request->action === "publish") ? true : false;
            $portfolio = $request->user()->portfolio()->create([
                            'title'         => $title,
                            'description'   => $description,
                            'is_public'     => $is_public,
                            'skills'        => $request->skills,
                        ]);
            if($is_public){
                $pointService->addPoint($request->user(), 'upload_portfolio');
            }
            return response()->json(true);
        }
    }

    public function savePortfolioThumbnail(Request $request)
    {
        $this->validate($request, [
            'thumbnail' => 'required|image'
        ]);

        $thumbnail = $request->file('thumbnail')->store('public');
        // echo $thumbnail; die();
        Image::make(storage_path().'/app/'.$thumbnail)->fit(800)->save();
        $path = storage_path().'/app/'.$thumbnail;

        if($request->uid !== "null")
        {
            $portfolio = $request->user()->portfolio()->where('uid', $request->uid)->first();
            event(new PortfolioImageUploadEvent($portfolio, $thumbnail, $portfolio->thumbnail));
            $url = config('app.url').'/'.$thumbnail;
            return response()->json(['thumbnail'=>$url], 200);

        } else {
            $uid = uniqid(true);
            $portfolio = $request->user()->portfolio()->create([
                'uid'   => $uid,
                'title' => $request->title,
                'thumbnail' => $thumbnail,
                'is_public' => false
            ]);
            event(new PortfolioImageUploadEvent($portfolio, $thumbnail));
            $url = config('app.url').'/'.$thumbnail;
            return response()->json(['uid'=>$uid, 'thumbnail' => $url], 200);
        }
    }

    public function addPortfolioThumbnail(Request $request)
    {
        // return response()->json($request); die();
        $this->validate($request, [
            'file'  => 'required|image'
        ]);

        $thumb = $request->file('file')->store('public');
        Image::make(storage_path().'/app/'.$thumb)->fit(480)->save();
        $user = $request->user();
        dispatch(new UploadFileToS3($thumb));

        if($request->uid !== null){
            $portfolio = $request->user()->portfolio()->where('uid', $request->uid)->first();
            $portfolio->thumbnail = $thumb;
            $portfolio->save();
            $portfolio = fractal()->item($portfolio)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
            return response()->json($portfolio, 200);
        } else {
            $uid = uniqid(true);
            $portfolio = $user->portfolio()->create([
                        'uid'       => $uid,
                        'title'     => $request->title,
                        'description'=> $request->description,
                        'thumbnail' => $thumb,
                        'is_public' => false,
                    ]);
            
            $portfolio = fractal()->item($portfolio)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
            return response()->json($portfolio, 200);
        }
    }

    public function fileUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimetypes:audio/mp3,audio/mpga,audio/mpeg,audio/wav,video/mp4,video/mpeg,image/png,image/jpg,image/jpeg,image/gif,'
        ]);

        $img_check = ['image/png','image/jpg','image/jpeg','image/gif'];
        $file = $request->file('file')->store('public');

        // reduce image size
        if(in_array($request->type, $img_check)){
            Image::make(storage_path('/app/'.$file))->resize(1240, null, function($const){
                $const->aspectRatio();
            })->save();
        }

        // Dispatch job to S3
        dispatch(new UploadFileToS3($file));

        if($request->uid !== null){

            $portfolio = $request->user()->portfolio()->where('uid', $request->uid)->first();
            $portfolio->files()->create([
                'file'      => $file,
                'file_type' => $request->type,
            ]);

            $portfolio = fractal()->item($portfolio)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();

            return response()->json($portfolio, 200);

        }
    }

    public function deleteFileUpload(Request $request, Portfolio $portfolio, File $file)
    {
        $this->authorize('delete', $portfolio);
        dispatch(new FileDeleteJob($file));
        $file->delete();
        return response()->json(true, 200);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorize('edit', $portfolio);
    	$this->validate($request, [
    		'title'	=> 'required|max:255'
    	]);
    	$portfolio->title = $request->title;
    	$portfolio->description = $request->description;
        $portfolio->is_public = $request->is_public;
        $portfolio->type = $request->type;
        $portfolio->skills = implode(', ', $request->skills);
        $portfolio->url = $request->url;
    	$portfolio->completion_date = $request->completion_date;
    	$portfolio->save();

        if($request->is_public == 1){
            $portfolio->activity()->create([
                'user_id'=> $request->user()->id,
                'title' => 'updated their portfolio',
                'type'  => 'portfolio'
            ]);
        }
    }

    public function delete(Request $request, Portfolio $portfolio, PointService $pointService)
    {
        
        return view('portfolio.delete')->with(['portfolio' => $portfolio]);
    }

    public function deletePortfolio(Request $request, Portfolio $portfolio, PointService $pointService)
    {
        // DeleteFileFromS3Storage
        $this->authorize('edit', $portfolio);
        $files = $portfolio->files()->get();
        $comments = $portfolio->comments()->get();
        $likes = $portfolio->likes()->get();
        $activities = $portfolio->activity()->get();

        // Delete all files from s3 storage to free up space
        $files->each(function($file, $key){
            dispatch(new DeleteFileFromS3Storage($file->file));
            $file->delete();
        });

        // Delete portfolio and thumbnail
        dispatch(new DeleteFileFromS3Storage($portfolio->thumbnail));
        $portfolio->delete();

        // Delete comments
        $comments->each(function($comment, $key){
            $comment->delete();
        });

        // Delete Activity
        // $activities->each(function($activity, $key){
        //     $activity->delete();
        // });

        // Delete Likes
        $likes->each(function($like, $key){
            $like->delete();
        });

        // Send confirmation message and redirect the user
        $request->session()->flash('status', $portfolio->title . ' has been successfully deleted');

        // Delete Point
        // $pointService->deletePoint($portfolio->user, 'portfolio');
        return redirect('/profile/portfolio');
    }

    // Get portfolio items endpoint
    public function getPortfolioItems(User $user)
    {
        $portfolio = $user->portfolio()->isPublic()->get();
        return response()->json($portfolio, 200);
    }

    public function view(Request $request, User $user, Portfolio $portfolio)
    {
        // $this->authorize('view', $portfolio);
        $info = fractal()->item($portfolio)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        $others = fractal()->collection($user->portfolio()->isPublic()->where('uid', '!=', $portfolio->uid)->get())
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();

        $similar = $this->similar($portfolio);
        // dd($similar);
        $avatar = '';
        if(Auth::user()) {
            $avatar = Auth::user()->profile->getAvatar();
        }
        return view('portfolio.view')->with([
            'portfolio' => $info,
            'files'     => $portfolio->files()->get(),
            'others'    => $others,
            'avatar'    => $avatar,
            'similar'   => $similar,
        ]);
    }

    public function similar(Portfolio $portfolio)
    {
        if($portfolio->skills){
            $skills = explode(', ', $portfolio->skills);
            $similar = Portfolio::whereIn('skills', $skills)->where([
                    ['is_public', '=', 1],
                    ['thumbnail', '!=', null],
                    ['id', '!=', $portfolio->id]
                ])->inRandomOrder()->take(9)->get();
            // dd($similar);
            if($similar){
                $portfolios = fractal()->collection($similar)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
                return $portfolios;
            }
        } else {
            return;
        }
    }

    public function homepagePortfolio(Request $request, Portfolio $portfolio)
    {
        return view('welcome');
    }

    public function homepagePortfolioAjax(Request $request, Portfolio $portfolio)
    {
        $records = $portfolio->isPublic()->hasThumbnail()->orderBy('is_featured', 'desc')->orderBy('updated_at', 'desc');
        $skip = (int)($request->page) * (int)$request->limit;
        $portfolios = fractal()->collection($records->latestFirst()->skip($skip)->take($request->limit)->get())
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        if($portfolios)
            return response()->json($portfolios, 200);
        else
            return response()->json(false, 422);
    }

    public function workPage(Portfolio $portfolio, Skills $skills)
    {
        return view('portfolio.index');
    }

    public function workSearchPage(Request $request, Skills $skills)
    {
        if($request->term){
            $similar = Portfolio::where('skills', 'like', '%'.$request->term)->where([
                    ['is_public', '=', 1],
                    ['thumbnail', '!=', null],
                ])->inRandomOrder()->take(16)->get();
            // dd($similar);
            if($similar){
                $portfolios = fractal()->collection($similar)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
                $skills = $skills->orderAlphabetically()->get();
                return view('portfolio.search')->with(['portfolios'=>$portfolios, 'skills'=>$skills]);
            }
        } else {
            return;
        }
        
    }

    public function makeFeaturedPortfolio(Request $request, Portfolio $portfolio)
    {
        if ( Auth::user()->is_admin === false ){
            return response()->json(false, 401);
        }

        $portfolio->is_featured = true;
        $portfolio->save();

        $work = fractal()->item($portfolio)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();

        $email = $portfolio->user->email;
        $title = $work['title'];
        $username = $work['user_profile']['username'];
        $thumbnail = $work['thumbnail'];
        $url = $work['link']['href'];
        $fname = $work['user_profile']['first_name'];
        Mail::to($email)->send(new FeaturedPortfolioNotification($title, $username, $thumbnail, $url, $fname));

        return response()->json(true, 200);
    }

    public function myLikedPortfolios(Request $request, Like $like, Portfolio $portfolio)
    {
        $likes = $like->where(['user_id'=>$request->user()->id, 'likeable_type' => 'App\Models\Portfolio'])->latestFirst()->get();
        $portfolios = [];
        // dd($likes);
        if($likes->count()){
            $portfolios = $likes->map(function($el, $index) use ($portfolio){
                        // dd($el->likeable_id);
                        $portfolio = $portfolio->find($el->likeable_id);
                        // var_dump($portfolio);
                        if($portfolio){
                            $p = fractal()->item($portfolio)
                                            ->transformWith(new PortfolioTransformer)
                                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                            ->toArray();
                            return $p;
                        } else {
                            return null;
                        }
                    });
        }
        return view('portfolio.likes')->with('portfolios', $portfolios);
    }
}
