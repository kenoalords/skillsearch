<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use App\Transformers\SimpleUserTransformers;
use Illuminate\View\View;

class TopUserComposer{

	public function compose(View $view)
	{		
		$collection = User::has('portfolio')->withCount(['portfolio' => function($query){
                                $query->where('is_public', true);
                            }])
                            ->join('profiles', function($join){
                                $join->on('profiles.user_id', '=', 'users.id')
                                    ->whereNotNull('avatar')
                                    ->whereNotNull('location')
                                    ->where('is_public', true);
                            })
                            ->orderBy('portfolio_count', 'desc')->take(10)->get();
        // dd($collection);
        $profiles = fractal()->collection($collection)
                            ->transformWith(new SimpleUserTransformers)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();
          // return $profiles;
          $view->with(['profiles' => $profiles]);
	}

}