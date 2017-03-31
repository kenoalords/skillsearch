<?php

namespace App\Http\Controllers;

use App\Models\SocialShare;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class SocialShareController extends Controller
{
    public function portfolio(Request $request, Portfolio $portfolio)
    {
    	// dd($request->ip());
    	$ip = $request->ip();
    	$portfolio->shares()->create([
    		'network'	=> $request->type,
    		'ip'		=> $ip
    	]);
    	if($request->type == 'facebook'){
    		$url = 'https://www.facebook.com/sharer/sharer.php?u='.$request->url;
    	}
    	if($request->type == 'twitter'){
    		$url = 'https://twitter.com/home?status='.$request->url;
    	}
    	if($request->type == 'google'){
    		$url = 'https://plus.google.com/share?url='.$request->url;
    	}
    	return redirect()->away($url);
    }
}
