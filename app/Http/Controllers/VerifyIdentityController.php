<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\UserImageJob;

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
        Image::make(storage_path() . '/app/' . $file)->resize(640, null, function($constraint){
            $constraint->aspectRatio();
        })->save();

    	$request->user()->identity()->create([
    		'scan_link' => $file
    	]);
        dispatch(new UserImageJob($file));
    	return redirect()->route('verify_identity');
    }
}
