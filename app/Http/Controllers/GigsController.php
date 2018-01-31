<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gig;
use App\Models\Skills;
use Illuminate\Http\Request;
use App\Traits\Orderable;
use App\Jobs\UploadFileToS3;
use App\Http\Requests\GigRequestValidation;
use App\Transformers\GigTransformer;
use League\Fractal\Resource\Collection;

class GigsController extends Controller
{
	use Orderable;

    public function index(Request $request)
    {
        $gigs = $request->user()->gigs()->latestFirst()->get();
        $gigs = fractal()->collection($gigs)
                            ->transformWith(new GigTransformer())
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                              ->toArray();
        return view('gigs.index')->with('gigs', $gigs);
    }
    	
    public function add(Request $request)
    {
		$skills = $request->user()->skills()->get();
		return view('gigs.add')->with([
							'skills' => $skills,
						]);
    }

    public function submit(GigRequestValidation $request)
    {
    		$file = $request->file('file')->store('public');
    		if( $file ){
    			dispatch(new UploadFileToS3($file));
    		}
    		$uid = uniqid(true);
    		$description = ($request->description != 'undefined') ? $request->description : '';
    		$gig = $request->user()->gigs()->create([
    			'title' 		=> $request->title,
    			'description'	=> $description,
    			'category'	=> $request->category,
    			'image'		=> $file,
    			'regular_price'=> $request->regular_price,
    			'sale_price'	=> $request->sale_price,
    			'delivery_time'=> $request->delivery_time,
    			'is_local'	=> $request->is_local,
    			'is_public'	=> $request->is_public,
    			'uid'		=> $uid,
    			'slug'		=> str_slug('I will ' . $request->title),
    		]);
    		return response()->json(true, 200);
    }

    public function gigs(Request $request, Gig $gigs)
    {
    		$gigs = $gigs->latestFirst()->get();
            // dd($gigs);
    		$gigs = fractal()->collection($gigs)
    						->transformWith(new GigTransformer())
    						->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                              ->toArray();
            
    		return view('gigs.gigs')->with(['gigs'=>$gigs]);
    }

    public function viewGig(Gig $gig)
    {
    		$gig = fractal()->item($gig)
    		               ->transformWith(new GigTransformer)
    					->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                         ->toArray();
          return view('gigs.single')->with([ 'gig'=>$gig ]);
    }

    
}
