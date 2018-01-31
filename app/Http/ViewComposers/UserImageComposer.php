<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\User;
use App\Transformers\SimpleUserTransformers;
use Illuminate\View\View;

class UserImageComposer{

	public function compose(View $view)
	{		
		$user = fractal()->item(User::find(Auth::user()->id))
                        ->transformWith(new SimpleUserTransformers)
                         ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                        ->toArray();
        $view->with(['user' => $user]);
	}

}