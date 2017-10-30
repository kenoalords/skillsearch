@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Find out how '.config('app.name').' can help promote your works and get you hired!')
@section('title', 'How It Works')

@section('content')
	
	<div id="points-header" class="page ui centered grid">
        <div class="center aligned fourteen wide mobile eight wide tablet eight wide computer column">
            <div class="">
                <h1 class="ui huge header">How It Works</h1>
            </div>
        </div>
	</div>
	<div id="">
    <div id="page" class="ui centered grid container" style="padding: 4em 1em">
    	<div class="fourteen wide mobile ten wide tablet ten wide computer column">
            <h2 class="ui header">Showcasing your creative works</h2>
    		<p>
    			{{config('app.name')}} is an online community tailored for creative people to showcase their work, collaborate and meet new clients.
    		</p> 
            <p>
                Members can showcase their works using a variety of formats;
            </p>
            <div class="row">
                <div class="ui centered equal width grid column">
                    <div class="column">
                        <h3 class="ui icon header">
                            <i class="icon image"></i>
                            Image
                        </h3>
                    </div>
                    <div class="column">
                        <h3 class="ui icon header">
                            <i class="icon music"></i>
                            Audio
                        </h3>
                    </div>
                    <div class="column">
                        <h3 class="ui icon header">
                            <i class="icon video"></i>
                            Video
                        </h3>
                    </div>
                </div>  
            </div>
    		<div class="ui divider"></div>
            <h2 class="ui header">Looking for creative people</h2>
            <p>
                You can post jobs on <a href="{{config('app.url')}}">{{config('app.url')}}</a> and receive applications from registered members.
            </p>
            <p>
                You can specify your budget, expiry date and the number of applications they want to receive. All jobs posted will pass through our vetting process to ensure strict compliance with our ethics
            </p>
            <p>
                To ensure the safety of all members, job posts from unverified accounts will be indicated as unverified to safeguard members. 
            </p>
            <p>
                <a href="/register" class="ui green large circular button">Sign up today</a>
            </p>
    	</div>
        
    </div>
</div>

@endsection