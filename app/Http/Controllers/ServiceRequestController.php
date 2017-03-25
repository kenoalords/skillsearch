<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    
    public function submitServiceRequests(Request $request, User $user, ServiceRequest $serviceRequest)
    {
    	$this->validate($request, [
    		'subject' 	=> 'required',
    		'body'		=> 'required',
    		'services'	=> 'required'
    	]);

    	$serviceRequest->create([
    		'user_id'		=> Auth::user()->id,
    		'receiver_id'	=> $user->id,
    		'subject'		=> $request->subject,
    		'body'			=> $request->body,
    		'skills'		=> implode(', ', $request->services),
    	]);

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
    	return response()->json($response, 200);
    }
}













