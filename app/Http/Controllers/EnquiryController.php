<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\UserEnquiryNotification;

class EnquiryController extends Controller
{
	public function form(Request $request, User $user){
		if ( $request->isMethod('get') )
			return view('enquiry.form')->with(['profile'=>$user->profile]);

		if ( $request->isMethod('post') ){
			$this->validate($request, [
				'fullname'=> 'required|min:3',
				'email'	=> 'required|email',
				'message'	=> 'required',
			]);

			$post = $user->enquiry()->create([
					'name'		=> $request->fullname,
					'email'		=> $request->email,
					'message'		=> $request->message,
					'phone_number'	=> $request->phone_number,
					'ip'			=> $request->ip(),
				]);
			if ( $post ){
				// Mail::to($user)->queue(new EnquiryNotification($user, $request->fullname, $request->email, $request->message));
				$user->notify(new UserEnquiryNotification($post, $request->fullname));
				return response()->json(true, 200);
			} else {
				return response()->json(false, 422);
			}			
		}
	}

	public function enquiries(Request $request){
		$unread = $request->user()->enquiry()->unread()->take(20)->get();
		return view('enquiry.enquiry')->with(['unread' => $unread]);
	}
}
