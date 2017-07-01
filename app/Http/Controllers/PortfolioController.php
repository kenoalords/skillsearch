<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\File;
use App\Models\Skills;
use App\Services\PointService;
use Illuminate\Http\Request;
use App\Events\PortfolioImageUploadEvent;
use App\Events\PortfolioFilesUploadEvent;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Transformers\PortfolioTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Jobs\DeleteFileFromS3Storage;


class PortfolioController extends Controller
{
    //
    // private $storage = Storage::disk('s3images');
    public function index(Request $request)
    {
        
        $portfolios = fractal()->collection($request->user()->portfolio()->get())
                            ->transformWith(new PortfolioTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
    	return view('portfolio.portfolio')->with(['portfolios' => $portfolios]);
    }

    public function add(Request $request)
    {
        $skills = $request->user()->skills()->get();
    	return view('portfolio.add')->with('skills', $skills);
    }

    public function edit(Request $request, Portfolio $portfolio)
    {
        $this->authorize('edit', $portfolio);
    	$files = $portfolio->files()->get();
        $skills = $request->user()->skills()->get();
        // dd($files->link);
    	return view('portfolio.edit')->with([
    		'portfolio' => $portfolio,
    		'files'		=> $files,
            'skills'    => $skills,
    	]);
    }

    public function savePortfolio(Request $request, PointService $pointService)
    {
    	if($request->type == 'images'){
    		$this->validate($request, [
    			'file' => 'required|image'
    		]);
    	}

    	if($request->type == 'audio'){
    		$this->validate($request, [
    			'file' => 'required|mimetypes:audio/mp3,audio/wav,audio/mpeg'
    		]);
    	}

        if($request->type == 'video'){
            $this->validate($request, [
                'file' => 'required|mimetypes:video/mp4,video/mpeg'
            ]);
        }
    	if( $request->uid && $request->file ){
    		$portfolio = $request->user()->portfolio()->where('uid', $request->uid)->first();
    		$image_url = $request->file('file')->store('public');
    		if($request->type == 'images'){
	    		Image::make(storage_path('/app/'.$image_url))->resize(1024, null, function($const){
	    			$const->aspectRatio();
	    		})->save();
	    	}
            event(new PortfolioFilesUploadEvent($image_url));
    		$file = $portfolio->files()->create([
    			'file'	=> $image_url
    		]);

            if($request->is_public == 1){
                // $pointService->addPoint($request->user, 'portfolio');
                $portfolio->activity()->create([
                    'user_id'=> $request->user()->id,
                    'title' => 'updated their portfolio',
                    'type'  => 'portfolio'
                ]);
            }
    		return response()->json([
    			'file' => [
                    'link'  => config('app.url').'/'.$file->file,
                    'id'    => $file->id
                ]
                
    		]);
    	} else {
	    	$uid = uniqid(true);
	    	$request->user()->portfolio()->create([
	    		'title'			=> $request->title,
	    		'description' 	=> $request->description,
	    		'is_public'		=> (int)$request->is_public,
	    		'uid'			=> $uid,
	    		'type'			=> $request->type
	    	]);

            if($request->is_public == 1){
                $portfolio->activity()->create([
                    'user_id'=> $request->user()->id,
                    'title' => 'updated their portfolio',
                    'type'  => 'portfolio'
                ]);
            }

	    	if( $request->file && $request->type == 'images' ){
	    		$portfolio = $request->user()->portfolio()->where('uid', $uid)->first();
	    		$image_url = $request->file('file')->store('public');
	    		if($request->type == 'images'){
		    		Image::make(storage_path('/app/'.$image_url))->resize(1024, null, function($const){
		    			$const->aspectRatio();
		    		})->save();
		    	}
                event(new PortfolioFilesUploadEvent($image_url));
	    		$file = $portfolio->files()->create([
	    			'file'	=> $image_url
	    		]);
	    		return response()->json([
	    			'uid' => $uid,
	    			'file' => [
                        'link'  => config('app.url').'/'.$file->file,
                        'id'    => $file->id
                    ]
	    		]);
	    	} else {

	    	}
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
                // 'thumbnail' => $thumbnail,
                'is_public' => false
            ]);
            event(new PortfolioImageUploadEvent($portfolio, $thumbnail));
            $url = config('app.url').'/'.$thumbnail;
            return response()->json(['uid'=>$uid, 'thumbnail' => $url], 200);
        }
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

    public function delete(Portfolio $portfolio, PointService $pointService)
    {
        return view('portfolio.delete')->with('portfolio', $portfolio);
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
        $activities->each(function($activity, $key){
            $activity->delete();
        });

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

    public function view(User $user, Portfolio $portfolio)
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
        return view('portfolio.view')->with([
            'portfolio' => $info,
            'files'     => $portfolio->files()->get(),
            'others'    => $others
        ]);
    }

    public function homepagePortfolio(Portfolio $portfolio, Skills $skills)
    {
        $portfolios = fractal()->collection($portfolio->isPublic()->hasThumbnail()->latestFirst()->take(10)->get())
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        $skills = $skills->orderAlphabetically()->get();

        return view('welcome')->with([
            'portfolios' => $portfolios,
            'skills'    => $skills,
        ]);
    }

    public function workPage(Portfolio $portfolio, Skills $skills)
    {
        $portfolios = fractal()->collection($portfolio->isPublic()->hasThumbnail()->latestFirst()->take(20)->get())
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        $skills = $skills->orderAlphabetically()->get();
        return view('portfolio.index')->with(['portfolios' => $portfolios, 'skills' => $skills ]);
    }
}
