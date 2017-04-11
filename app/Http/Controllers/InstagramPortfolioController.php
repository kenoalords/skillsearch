<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstagramService;

class InstagramPortfolioController extends Controller
{

    public function index()
    {	
    	return view('portfolio.instagram');
    }

    public function get(InstagramService $instagram)
    {
    	return $instagram->auth();
    }

    public function redirect(Request $request, InstagramService $instagram)
	{
		$media = $instagram->getUser($request);
	}
}
