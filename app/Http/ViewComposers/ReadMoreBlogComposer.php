<?php

namespace App\Http\ViewComposers;

use App\Models\Blog;
use Illuminate\View\View;
use App\Transformers\BlogTransformer;
use App\Traits\Orderable;
use League\Fractal\Resource\Collection;
// use DB;

class ReadMoreBlogComposer{
	use Orderable;

	public $data;

	public function __construct($data)
	{
		$this->data = $data;
	}

	public function compose(View $view)
	{

		$blogs = Blog::where(['is_public'=>true, 'status'=>'publish'])->where('id', '!=', $this->data['id'])->latestFirst()->take(6)->get();
		$payload = fractal()->collection($blogs)
                        ->transformWith(new BlogTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
		$view->with(['blogs' => $payload]);
	}

}