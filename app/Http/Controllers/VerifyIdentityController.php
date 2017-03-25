<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyIdentityController extends Controller
{
    public function verify(Request $request)
    {
    	$user = $request->user()->identity()->first();
    	return view('profile.identity')->with('user', $user);
    }

    public function upload(Request $request)
    {
    	$this->validate($request, [
    		'identity-card' => 'required|image'
    	]);

    	$file = $request->file('identity-card')->store('public');
    	$request->user()->identity()->create([
    		'scan_link' => $file
    	]);
    	return redirect()->route('verify_identity');
    }
}
