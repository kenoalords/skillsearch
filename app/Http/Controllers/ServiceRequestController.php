<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\RequestServiceNotification;
use App\Mail\RequestServiceResponseNotification;

class ServiceRequestController extends Controller
{
    
    public function submitServiceRequests(Request $request, User $user, ServiceRequest $serviceRequest)
    {
    	$this->validate($request, [
    		'subject' 	=> 'required',
    		'body'		=> 'required',
    		'services'	=> 'required'
    	]);
        $skills = implode(', ', $request->services);
    	$serviceRequest->create([
    		'user_id'		=> Auth::user()->id,
    		'receiver_id'	=> $user->id,
    		'subject'		=> $request->subject,
    		'body'			=> $request->body,
    		'skills'		=> $skills,
    	]);

        Mail::to($user)->queue(new RequestServiceNotification(Auth::user(), $user, $skills, $request->body));
    	return response()->json(null, 200);

    }

    public function getServiceRequests(ServiceRequest $serviceRequest)
    {
    	$user = Auth::user();
    	$requests = $serviceRequest->allRequests($user)->get();
     	return view('requests.index')->with('requests', $requests);
    }

    public function getServiceRequestResponses(Request $request, ServiceRequestResponse $response)
    {
    	$requestResponses = $response->where('request_id', $request->request_id)->get();
    	return response()->json($requestResponses, 200);
    }

    public function postServiceRequestResponses(Request $request)
    {
    	$response = $request->user()->responses()->create([
    		'request_id'	=> $request->request_id,
    		'response'		=> $request->response
    	]);
        $r = ServiceRequest::where('id', $request->request_id)->first();

        $user = ($r->user_id === $request->user()->id) ? $r->receiver_id : $r->user_id;
        $reciever = User::where('id',$user)->first();
        Mail::to($reciever)->queue(new RequestServiceResponseNotification($r, $reciever));
    	return response()->json($response, 200);
    }
}













