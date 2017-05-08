<?php

namespace App\Http\Controllers;

use App\Models\ContactInvite;
use Illuminate\Http\Request;

class UnsubscribeController extends Controller
{
    public function unsubscribeContactInviteReminder(Request $request, ContactInvite $contactInvite)
    {
    	$email = $request->email;
    	if($email == ''){
    		return redirect(config('app.url'));
    	}

    	$invite = $contactInvite->where('email', urldecode($email))->first();
    	// dd($invite);
    	if($invite){
    		$invite->forceDelete();
    		return view('contacts.unsubscribed')->with('email', $email);
    	} else {
    		return view('contacts.notfound')->with('email', $email);
    	}
    }
}
