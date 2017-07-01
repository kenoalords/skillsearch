@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Find out how Skillsearch Nigeria can help promote your works and get you hired!')
@section('title', 'How It Works')

@section('content')
	
	<div id="points-header" class="page padded text-center">
        <div class="container">
            <div class="col-sm-8 col-sm-offset-2">
                <h1 class="bold">How It Works</h1>
            </div>
        </div>
	</div>
	<div id="">
    <div id="page" class="container">
    	<div class="col-sm-8 col-sm-offset-2 padded">
            <h3 class="bold">For Skilled People</h3>
    		<p>
    			{{config('app.name')}} is a community tailored for skilled people to showcase their work, collaborate and meet new clients.
    		</p> 
    		<p>
    			Members can <a href="/register" class="bold">sign up for a free account</a> and start showcasing their works using Images, Videos and Audios.
    		</p>
    		<p>
    			<a href="/register" class="btn btn-primary">Create your <strong>FREE Account</strong></a>
    		</p>
    		<hr>
            <h3 class="bold">For Employers</h3>
            <p>
                Employers can post jobs on <a href="{{config('app.url')}}">{{config('app.url')}}</a> and receive applications from registered members.
            </p>
            <p>
                Employers can specify their budget, expiry date and the number of applications they want to receive. All jobs posted will pass through our vetting process to ensure strict compliance with our ethics
            </p>
            <p>
                To ensure the safety of all members, job posts from unverified accounts will be indicated as unverified to safeguard members. 
            </p>
            <p>
                <a href="/register" class="btn btn-primary">Create your <strong>FREE Account</strong></a>
            </p>
    	</div>
        
    </div>
</div>

@endsection