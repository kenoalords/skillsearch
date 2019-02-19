<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class SocialAccountLinkupController extends Controller
{
    public function index(Request $request)
    {
		return view('auth.confirm_password')->with('request', $request->all());
    }

    public function mergeAccounts(Request $request)
    {
    	$this->validate($request, [
    		'password' => 'required'
    	]);

    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
            $user = User::where('name', $request->user)->first();
            $user->social()->create([
            	'provider_user_id'	=> $request->social_id,
            	'provider'			=> $request->provider,
            ]);
            $request->session()->flash('status', 'You can now login with your ' . $request->provider . ' account.');
            return redirect('/dashboard');
        } else {
        	$request->session()->flash('status', 'Your password is incorrect');
        	return back();
        }
    }
}
