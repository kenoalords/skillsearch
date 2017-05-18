<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

class SearchController extends Controller
{
	use Searchable;
	
    public function searchProfiles(Request $request, Profile $profile)
    {
    	$results = $profile->where('bio', 'like', $request->term . ' ' . $request->location)->where('is_public', 1)->get();
    	// dd($results);
    	return view('search')->with('profiles', $results);
    }
}
