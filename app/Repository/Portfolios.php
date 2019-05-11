<?php

namespace App\Repository;
use App\Models\Portfolio;
use Carbon\Carbon;
use App\Transformers\SimplePortfolioTransformer;
use App\Transformers\PortfolioTransformer;

class Portfolios
{
	CONST CACHE_KEY = 'PORTFOLIOS';
	public function featured($skip, $limit)
	{
		$key = 'featured.'.$skip . '.' . $limit;
		$cache_key = $this->getCacheKey($key);

		return cache()->remember($cache_key, Carbon::now()->addMinutes(15), function() use($skip, $limit) {
			$portfolios = Portfolio::where([ 'is_featured' => 1])->isPublic()->hasThumbnail()->orderBy('updated_at', 'desc')->skip($skip)->take($limit)->get();
			return $this->transformCollection($portfolios);
		});
	}

	public function loadPortfolios($category='', $limit=20)
	{
		$key = $category . '.' . $limit;
		$cache_key = $this->getCacheKey($key);

		return cache()->remember($cache_key, Carbon::now()->addMinutes(15), function() use($category, $limit) {
			// Get portfolios by category
			$portfolios = Portfolio::where('skills', 'like', '%'.$category)->isPublic()->hasThumbnail()->orderBy('is_featured', 'desc')->take($limit)->get();
			return $this->transformCollection($portfolios);
		});
	}

	public function latest($skip, $limit)
	{
		$key = 'latest.'.$skip . '.' . $limit;
		$cache_key = $this->getCacheKey($key);

		return cache()->remember($cache_key, Carbon::now()->addMinutes(15), function() use($skip, $limit){
			$portfolios = Portfolio::isPublic()
							 ->hasThumbnail()
							 ->orderBy('created_at', 'desc')
							 ->skip($skip)
							 ->take($limit)
							 ->get();
			return $this->transformCollection($portfolios);
		});
	}

	public function get(Portfolio $portfolio)
	{
		$key = $this->getCacheKey($portfolio->uid);
		return cache()->remember($key, Carbon::now()->addMonths(1), function() use($portfolio){
			return $this->transformItem($portfolio);
		});
	}

	public function transformCollection($portfolios)
	{
		return fractal()->collection($portfolios)
                        ->transformWith(new SimplePortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
	}

	public function transformItem($portfolio)
	{
		return fractal()->item($portfolio)
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
	}



	public function getCacheKey($key)
	{
		$key = strtoupper($key);
		return self::CACHE_KEY . ".$key";
	}
}
