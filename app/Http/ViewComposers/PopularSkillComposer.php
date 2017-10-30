<?php

namespace App\Http\ViewComposers;

use App\Models\SkillsRelations;
use Illuminate\View\View;
use DB;

class PopularSkillComposer{

	public function compose(View $view)
	{
		$skills = SkillsRelations::select(DB::raw('skill, COUNT(*) as count'))
		                           ->groupBy('skill')
		                           ->orderBy('count', 'desc')
		                           ->take(18)
		                           ->get();
		$view->with('skills', $skills);
	}

}