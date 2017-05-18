<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use App\Models\ContactInvite;
use App\Mail\ContactInviteMail;
use App\Services\PointService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OAuth;
use Mail;

class InviteContactController extends Controller
{
    public function index()
    {
    	return view('contacts.index');
    }

    public function gmailContactInvite(Request $request, ContactInvite $contactInvite)
    {
    	$code = $request->get('code');
    	$googleService = \OAuth::consumer('Google');

    	if ( ! is_null($code)) {
	        // This was a callback request from google, get the token
	        $token = $googleService->requestAccessToken($code);

	        // Send a request with it
	        $result = json_decode($googleService->request('https://www.google.com/m8/feeds/contacts/default/full?alt=json&max-results=5000'), true);

	        // Going through the array to clear it and create a new clean array with only the email addresses
	        $emails = []; // initialize the new array
	        $friends = [];

	        $invitee_name = $result['feed']['author'][0]['name']['$t'];
	        $invitee_email = $result['feed']['author'][0]['email']['$t'];

	        $inviteCheck = ContactInvite::where('invitee_email', $invitee_email)->get();
	        if(!$inviteCheck->count()){
		        foreach ($result['feed']['entry'] as $contact) {
		            if (isset($contact['gd$email'])) { // Sometimes, a contact doesn't have email address

		            	$email = $contact['gd$email'][0]['address'];

		                $friends_check = User::where('email', $email)->first();
		                if($friends_check){
		                	// check if the inviting user is registered
		                	// check if the inviting user has connected with the person they are inviting
		                	$is_registered_request = User::where('email', $invitee_email)->first();
		                	// If its an authenticated request
		                	if(Auth::user()){
		                		$is_following = Auth::user()->followers()->where('following_id', $friends_check->id)->first();
		                		if(!$is_following){
		                			array_push($friends, $friends_check);
		                		}
		                	}
		                } else {
		                	array_push($emails, [
			                	'email'=> $email,
			                	'name' => ucwords(strtolower($contact['title']['$t']))
			                ]);
		                }
		            }
		        }
		    } else {
		    	return view('contacts.show_invites')->with([
		    		'invites' => $inviteCheck,
		    		'invitee_name' => $invitee_name
		    	]);
		    }
	        // dd($friends);
	        
	        return view('contacts.gmail')->with([
	        		'invitee_name'	=> $invitee_name,
	        		'invitee_email'	=> $invitee_email,
	        		'total_contacts'=> number_format((int)$result['feed']['openSearch$totalResults']['$t']),
	        		'emails'		=> $emails,
	        		'friends'		=> $friends
	        	]);

	    }
	    
	    // if not ask for permission first
	    else {
	        // get googleService authorization
	        $url = $googleService->getAuthorizationUri();

	        // return to google login url
	        return redirect((string)$url);
	    }
    }

    public function gmailContactInviteRequest(Request $request, ContactInvite $contactInvite, PointService $pointService)
    {
    	$emails = $request->invite;
    	if($emails){
    		foreach($emails as $email){

    			$invite = explode('|', $email);
    			$check = User::where('email', $invite[1])->first();
    			if(!$check){
					$contactInvite->create([
		            	'invitee_name'	=> $request->invitee_name,
		            	'invitee_email'	=> $request->invitee_email,
		            	'fullname'		=> $invite[0],
		            	'email'			=> $invite[1],
		            	'medium'		=> 'gmail'
		            ]);
		            Mail::to($invite[1])->send(new ContactInviteMail($request->invitee_name, $invite[0], $invite[1]));
		        }
    		}

    		$invitingUser = User::where('email', $request->invitee_email)->first();
    		if($invitingUser){
    			$pointService->addPoint($invitingUser, 'invite');
    		}
    		return redirect('/invite/success')->with('name', $request->invitee_name);
    	}
    }

    public function thankYou(Request $request)
    {
    	return view('contacts.thankyou');
    }
}
