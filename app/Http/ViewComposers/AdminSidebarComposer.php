<?php

namespace App\Http\ViewComposers;

use App\Models\ContactRequest;
use App\Models\SkillsRelations;
use Illuminate\View\View;
use Auth;

class AdminSidebarComposer{

	public function compose(View $view)
	{
		$profile = Auth::user()->profile;
		$req = Auth::user()->contactRequest()->where('is_approved', false)->count();
		$view->with(['profile' => $profile, 'req' => $req]);
	}

}