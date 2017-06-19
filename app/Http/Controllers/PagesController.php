<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about(Request $request)
    {
    	return view('pages.about');
    }

    public function contact(Request $request)
    {
    	return view('pages.contact');
    }

    public function works(Request $request)
    {
    	return view('pages.works');
    }

    public function privacy(Request $request)
    {
    	return view('pages.privacy');
    }

    public function points(Request $request)
    {
        return view('pages.points');
    }
}
