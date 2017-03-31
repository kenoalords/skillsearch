<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExternalLinkController extends Controller
{
    public function index(Request $request)
    {
    	return redirect()->away($request->url);
    }
}
