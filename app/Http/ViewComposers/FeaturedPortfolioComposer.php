<?php

namespace App\Http\ViewComposers;

use App\Models\Portfolio;
use App\Transformers\PortfolioTransformer;
use Illuminate\View\View;

class FeaturedPortfolioComposer{

	public function compose(View $view)
	{		
		$records = Portfolio::isPublic()->hasThumbnail();
        	$portfolios = fractal()->collection($records->isFeatured()->take(20)->get())
                        ->transformWith(new PortfolioTransformer)
                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
          $view->with(['portfolios' => $portfolios]);
	}

}