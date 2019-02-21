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
use App\Http\Requests\PortfolioRequest;
use Facades\App\Repository\Portfolios;
use App\Notifications\PortfolioFeaturedNotification;

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

    public function add(Request $request, PointService $pointService)
    {
        if ( $request->isMethod('get') ){
            $skills = fractal()->collection($request->user()->skills()->get())
                            ->transformWith(new SkillsTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
        	return view('portfolio.add')->with(['skills' => $skills]);
        }

        if ( $request->isMethod('post') ){
            // Save the thumbnail
            if ( $request->hasFile('thumbnail') ){
                $thumbnail = $request->file('thumbnail')->store('public');
                Image::make(storage_path().'/app/'.$thumbnail)->fit(400)->save();
                $path = storage_path().'/app/'.$thumbnail;
                dispatch(new UploadFileToS3($thumbnail));
            } else {
                $thumbnail = null;
            }           
            $uid = uniqid(true);
            $title = ($request->title) ? $request->title : 'Draft Portfolio';
            $description = ($request->description) ? $request->description : '';
            $is_public = ($request->action === "publish") ? true : false;
            $portfolio = $request->user()->portfolio()->create([
                    'uid'           => uniqid(true),
                    'title'         => $title,
                    'description'   => $description,
                    'is_public'     => $is_public,
                    'skills'        => $request->skills,
                    'thumbnail'     => $thumbnail,
                ]);        
            
            if ( $request->hasFile('files') ){
                $files = $request->file('files');
                foreach ( $files as $item ){
                    $filename = $item->store('public');
                    $portfolio->files()->create([
                        'file'  => $filename,
                        'file_type' => $item->getMimeType(),
                    ]);
                    dispatch(new UploadFileToS3($filename));
                }
            }
            if($is_public){
                $pointService->addPoint($request->user(), 'upload_portfolio');
            }
            return response()->json(true);
        }
    }

    public function edit(Request $request, Portfolio $portfolio)
    {
        $this->authorize('edit', $portfolio);
        // Handle GET request
        if ( $request->isMethod('get') ){
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

        // Handle PUT requests
        if ( $request->isMethod('put') ){
            $portfolio->title = $request->title;
            $portfolio->description = $request->description;
            $portfolio->skills = $request->skills;

            // Check if thumbnail file was uploaded
            if ( $request->hasFile('thumbnail') ){
                $thumbnail = $request->file('thumbnail')->store('public');
                Image::make(storage_path().'/app/'.$thumbnail)->fit(400)->save();
                $path = storage_path().'/app/'.$thumbnail;
                dispatch(new UploadFileToS3($thumbnail));
                $portfolio->thumbnail = $thumbnail;
            }

            // Check if new files where added to the portfolio
            if ( $request->hasFile('files') ){
                $files = $request->file('files');
                foreach ( $files as $item ){
                    $filename = $item->store('public');
                    $portfolio->files()->create([
                        'file'  => $filename,
                        'file_type' => $item->getMimeType(),
                    ]);
                    dispatch(new UploadFileToS3($filename));
                }
            }
            $portfolio->save();
            return response()->json(true, 200);
        }

        if ( $request->isMethod('delete') ){
            $files = $portfolio->files()->get();
            $comments = $portfolio->comments()->get();
            $likes = $portfolio->likes()->get();

            // Delete all files from s3 storage to free up space
            $files->each(function($file, $key){
                if ( Storage::exists($file->file) ){
                    Storage::delete($file->file);
                    $file->delete();
                } else {
                    dispatch(new DeleteFileFromS3Storage($file->file));
                    $file->delete();
                }               
            });

            // Delete portfolio and thumbnail
            if ( Storage::exists($portfolio->thumbnail) ){
                Storage::delete($portfolio->thumbnail);
            } else {
                dispatch(new DeleteFileFromS3Storage($portfolio->thumbnail));
            }

            // Delete comments
            $comments->each(function($comment, $key){
                $comment->delete();
            });

            // Delete Likes
            $likes->each(function($like, $key){
                $like->delete();
            });
            $portfolio->delete();
            return response()->json(true, 200);
        }
    }

    public function deleteFileUpload(Request $request, Portfolio $portfolio, File $file)
    {
        $this->authorize('delete', $portfolio);
        dispatch(new FileDeleteJob($file));
        $file->delete();
        return response()->json(true, 200);
    }

    // Get portfolio items endpoint
    public function getPortfolioItems(User $user)
    {
        $portfolio = $user->portfolio()->isPublic()->get();
        return response()->json($portfolio, 200);
    }

    public function view(Request $request, User $user, Portfolio $portfolio)
    {
        if ($portfolio->is_public === 0){
            return redirect('/');
        }
        $start_time = microtime(true);
        $info = Portfolios::get($portfolio);
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
        $duration = (microtime(true) - $start_time) * 1000;
        return view('portfolio.view')->with([
            'portfolio' => $info,
            'files'     => $portfolio->files()->get(),
            'others'    => $others,
            'avatar'    => $avatar,
            'similar'   => $similar,
            'duration'  => floor($duration),
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
        $start_time = microtime(true);
        $skip = (int)($request->page) * (int)$request->limit;
        $limit = (int)$request->limit;

        if ( $request->get('type') === "featured" ){
            $portfolios = Portfolios::featured($skip, $limit);
        } else if ( $request->get('type') === "latest" ){
            $portfolios = Portfolios::latest($skip, $limit);
        }

        if($portfolios){
            $duration = (microtime(true) - $start_time) * 1000;
            return response()->json(['portfolios'=>$portfolios, 'duration'=>$duration], 200);
        }else{
            return response()->json(false, 422);
        }
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

        $portfolio->user->notify(new PortfolioFeaturedNotification($portfolio));

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

    public function getFiles(Request $request, Portfolio $portfolio)
    {
        return response()->json($portfolio->files()->get(), 200);
    }
}
