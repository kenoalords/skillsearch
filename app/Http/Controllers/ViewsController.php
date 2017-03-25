<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function create(Request $request, Portfolio $portfolio)
    {
    	$view = $portfolio->views()
    	 ->where('ip', $request->ip())
    	 ->whereDate('created_at', date('Y-m-d'))->get();

    	// dd($view);
    	if(!$view->count()){
    		$portfolio->views()->create([
    			'ip' => $request->ip()
    		]);
    		return response()->json(null, 200);
    	}
    }
}
