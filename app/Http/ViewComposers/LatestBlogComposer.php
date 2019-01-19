<?php

namespace App\Http\ViewComposers;

use App\Models\Blog;
use Illuminate\View\View;
use App\Transformers\BlogTransformer;
use App\Traits\Orderable;
use League\Fractal\Resource\Collection;
// use DB;

class LatestBlogComposer{
	use Orderable;

	public function compose(View $view)
	{
		$blogs = Blog::where(['is_public'=>true, 'status'=>'publish'])->latestFirst()->take(6)->get();
		$payload = fractal()->collection($blogs)
                        ->transformWith(new BlogTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
		$view->with(['blogs' => $payload]);
	}

}