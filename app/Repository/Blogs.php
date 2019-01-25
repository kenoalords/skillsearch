<?php

namespace App\Repository;

use App\Models\Blog;
use App\Transformers\BlogTransformer;
use Carbon\Carbon;

class Blogs
{
	CONST CACHE = 'BLOG';

	public function get(Blog $blog)
	{
		$cache_key = $this->getCacheKey($blog->uid);
		return cache()->remember($cache_key, Carbon::now()->addMonths(6), function() use($blog) {
			return $this->transformItem($blog);
		});
	}

	public function transformItem($blog)
	{
		return fractal()->item($blog)
                        ->transformWith(new BlogTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
	}

	public function getCacheKey($key)
	{
		$key = strtoupper($key);
		return self::CACHE . ".{$key}";
	}
}