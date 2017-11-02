<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use App\Transformers\SimpleUserTransformers;
use App\Http\Requests\ContactRequestValidation;
use App\Mail\ContactRequestNotification;
use App\Mail\ContactRequestApproveNotification;
use App\Mail\ContactRequestResponseNotification;
use Mail;

class ContactRequestController extends Controller
{
    public function index(User $user)
    {
    	$user = fractal()->item($user)
    					->transformWith(new SimpleUserTransformers)
    					->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
    					->toArray();
    	return view('contact-request.index')->with([
    				'profile'	=> $user,
    			]);
    }

    public function submit(ContactRequestValidation $request, User $user)
    {
    	$ip = $request->ip();
    	$geoip = geoip()->getLocation($ip);
    	// dd($geoip);
    	$post = $user->contactRequest()->create([
    				'fullname'	=> $request->fullname,
    				'email'		=> $request->email,
    				'phone'		=> $request->phone,
    				'location'	=> $request->location,
    				'ip'		=> $ip,
    				'country'	=> $geoip->country,
    				'iso_code'	=> $geoip->iso_code,
    				'city'		=> $geoip->city,
    				'state_name'=> $geoip->state_name,
    				'lat'		=> $geoip->lat,
    				'lon'		=> $geoip->lon,
    				'timezone'	=> $geoip->timezone,
    				'currency'	=> $geoip->currency,
    			]);
    	if($post){
    		$name = ucwords($user->profile->first_name);
    		// dd($name);
    		Mail::to($user)->send(new ContactRequestNotification($name, $request->fullname));
    		Mail::to($request->email)->send(new ContactRequestResponseNotification($request->fullname, $name));
    		return redirect()->route('contact_request_status', ['status' => 'sent', 'user' => $user->name, 'sender' => $request->fullname, 'name' => $name ]);
    	}
    }

    public function status(Request $request)
    {
    	return view('contact-request.status');
    }

    public function requests(Request $request)
    {
    	$approved = $request->user()->contactRequest()->where('is_approved', true)->get();
    	$pending = $request->user()->contactRequest()->where('is_approved', false)->get();
    	return view('contact-request.requests')->with([
    				'approved'	=> json_encode($approved),
    				'pending'	=> json_encode($pending),
    			]);
    }

    public function approveRequest(Request $request, ContactRequest $contact_request)
    {
    	$this->authorize('update', $contact_request);
    	$contact_request->is_approved = true;
    	$contact_request->save();

    	$username = $request->user()->profile->first_name;
    	$phone = $request->user()->phone()->first();

    	Mail::to($contact_request->email)->send(new ContactRequestApproveNotification($contact_request->fullname, $username, $phone->number));

    	return response()->json(1, 200);
    }
}
