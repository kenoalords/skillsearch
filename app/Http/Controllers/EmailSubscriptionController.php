<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscription;
use Illuminate\Http\Request;

class EmailSubscriptionController extends Controller
{
    public function emailSubscription(Request $request, EmailSubscription $subscription)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $check = $subscription->where('email', $request->email)->get();
        if ( $check->count() > 0 ) {
        	return response()->json([ 'status' => true ], 200);
        }
        $insert = $subscription->create([ 'email'  => $request->email ]);
        return response()->json([ 'status' => true ], 200);
    }
}
