<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\Enquiry;
use App\Transformers\PortfolioTransformer;
use Illuminate\View\View;

class EnquiryCountComposer{

	protected $user;

	public function compose(View $view)
	{	
		if ( Auth::user() ){
			$count = Auth::user()->enquiry()->unread()->count();
          	$view->with(['enquiry_count' => $count]);
		}	
	}

}