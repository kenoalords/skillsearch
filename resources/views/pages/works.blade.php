@extends('layouts.page')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Find out how '.config('app.name').' can help promote your works and get you hired!')
@section('title', 'How It Works')

@section('content')
	
<h1 class="title">How It Works</h1>

<h2 class="title is-4">Showcasing your creative works</h2>
<p>
    {{config('app.name')}} is an online community tailored for creative people to showcase their work, collaborate and meet new clients.
</p> 
<p>
    Members can showcase their works using a variety of formats;
</p>

<div class="level is-mobile" style="margin: 1em 0; background-color: #f5f5f5; padding: 1em;">
    <div class="level-item">
        <h3 class="ui icon header">
            <span class="icon"><i class="fa fa-image"></i></span>
            <span style="margin-left: .5em">Image</span>
        </h3>
    </div>
    <div class="level-item">
        <h3 class="ui icon header">
            <span class="icon"><i class="fa fa-music"></i></span>
            <span style="margin-left: .5em">Audio</span>
        </h3>
    </div>
    <div class="level-item">
        <h3 class="ui icon header">
            <span class="icon"><i class="fa fa-video"></i></span>
            <span style="margin-left: .5em">Video</span>
        </h3>
    </div>
</div> 

<div class="ui divider"></div>
<h2 class="title is-4">Looking for creative people</h2>
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
    <a href="/register" class="button is-primary">
        <span>Sign up today</span>
        <span class="icon"><i class="fa fa-long-arrow-right"></i></span>
    </a>
</p>

@endsection