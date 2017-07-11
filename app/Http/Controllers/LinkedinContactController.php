<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\LinkedinContacts;
use Illuminate\Http\Request;

class LinkedinContactController extends Controller
{
    public function index( Request $request, LinkedinContacts $linkedinContacts )
    {
    	$contacts = $linkedinContacts->all();
    	return view('linkedin.index')->with(['contacts'=>$contacts]);
    }

    public function upload( Request $request, LinkedinContacts $linkedinContacts )
    {
    	// dd($request->file('upload'));
    	Excel::load($request->file('upload'), function($reader){
    		$contacts = $reader->get();
    		foreach ($contacts as $contact){
    			if($contact->emailaddress){
    				$check = LinkedinContacts::where('email', $contact->emailaddress)->first();
    				if(!$check){
    					LinkedinContacts::create([
    						'first_name'	=> $contact->firstname,
    						'last_name'		=> $contact->lastname,
    						'title'			=> $contact->title,
    						'email'			=> $contact->emailaddress,
    					]);
    				}
    			}
    		}
    		return redirect('home/linkedin_upload');
    	});
    }
}
