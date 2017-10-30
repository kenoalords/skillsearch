<?php

namespace App\Http\Controllers;

use App\Models\ReferralCode;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralCodeController extends Controller
{
    public function index(Request $request)
    {
    	$code = $request->user()->referralCode()->first();
    	if($code){
    		$ref = $code->code;
    	}else{
    		$ref = '';
    	}
    	return view('admin.referral')->with('code', $ref);
    }

    public function generate(Request $request)
    {
    	$code = $request->user()->referralCode()->first();
    	if(!$code){
    		$rand = substr($request->user()->name, 0, 3) . $request->user()->id . random_int(256, 1024);
    		$generate = $request->user()->referralCode()->create([
    			'code' => $rand,
    		]);
    		if($generate){
    			return response()->json($generate, 200);
    		}
    	} else {
    		return false;
    	}
    }
}
