<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\InstagramService;
use App\Transformers\ProfileTransformers;

class InstagramPortfolioController extends Controller
{

    public function index(Request $request)
    {	
        $token = $request->user()->instagram()->first();
    	return view('portfolio.instagram')->with(['token'=>$token]);
    }

    public function get(InstagramService $instagram)
    {
    	return $instagram->auth();
    }

    public function redirect(Request $request, InstagramService $instagram)
	{
		$token = $instagram->getUser($request);
        if($token){
            return view('portfolio.instagram')->with(['token'=>$token]);
        } else {
            return view('portfolio.instagram')->with([
                'token' => false,
            ]);
        }
	}

    public function delete(Request $request)
    {
        $request->user()->instagram()->delete();
        $token = $request->user()->instagram()->first();
        return view('portfolio.instagram')->with(['token' => $token]);
    }
}
