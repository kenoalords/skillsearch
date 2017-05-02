@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Find out how Skillsearch Nigeria can help promote your works and get you hired!')
@section('title', 'How It Works')

@section('content')
	
	<div id="hero" class="page padded text-center">
		<h1>How It Works</h1>
	</div>
	<div id="how">
    <div id="page" class="container text-center padded">
    	<div class="col-sm-8 col-sm-offset-2 padded">
    		<p style="font-size: 1.2em; font-weight: 700">
    			Frankly speaking, we have made <a href="{{config('app.url')}}">skillsearch.com.ng</a> easy to use.
    		</p> 
    		<p style="font-size: 1.2em">
    			At it's core, <a href="{{config('app.url')}}">skillsearch.com.ng</a> is designed to help you showcase images, videos and audio of your works quickly and easily.
    		</p>
    		<p>
    			<a href="/register" class="btn btn-primary">Create your <strong>Account</strong></a>
    		</p>
    		<hr>
    	</div>
        <div class="col-sm-6 col-md-3">
            <!-- <img src="{{asset('public/signup.png')}}" alt="" class="img-responsive"> -->
            <i class="fa fa-id-badge"></i>
            <h4 class="text-uppercase">Create a free profile</h4>
            <p>It takes less than 30 seconds to setup an account.</p>
        </div>
        <div class="col-sm-6 col-md-3">
            <!-- <img src="{{asset('public/select-skills.png')}}" alt="" class="img-responsive"> -->
            <i class="fa fa-vcard"></i>
            <h4 class="text-uppercase">Select your skills</h4>
            <p>Choose from a wide range of categories that match your skills.</p>
        </div>
        <div class="col-sm-6 col-md-3">
            <!-- <img src="{{asset('public/upload.png')}}" alt="" class="img-responsive"> -->
            <i class="fa fa-image"></i>
            <h4 class="text-uppercase">Upload portfolio</h4>
            <p>Show us what you can do by uploading your past works.</p>
        </div>
        <div class="col-sm-6 col-md-3">
            <!-- <img src="{{asset('public/offers.png')}}" alt="" class="img-responsive"> -->
            <i class="fa fa-briefcase"></i>
            <h4 class="text-uppercase">Receive offers</h4>
            <p>Start receiving offers from potential clients and earn much more.</p>
        </div>
    </div>
</div>

@endsection