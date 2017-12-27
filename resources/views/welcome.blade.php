@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Home')
@section('metadescription', 'Showcase your skills, find latest jobs and get hired on Nigeria preferred skills promotion platform')
@section('content')
<!-- @include('search-form') -->
<div id="hero">
    <div class="ui container">
        <div class="ui centered grid">
            <h1 class="ui header" style="margin-bottom: 1em">
                Discover great talents
                <div class="sub header">Find the right people for your jobs in Nigeria</div>
            </h1>
            @include('search-form') 
        </div>
    </div>
</div>

<div id="showcase">
    <div class="ui container">
        <h1 class="ui centered header">Featured work</h1>
        <div class="ui grid slick-js" id="portfolio-data" style="padding: 2em 0">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>
        @if( !Auth::user() )
            <div class="ui centered grid" style="margin-top: 2em">
                <h4 class="ui grey header">
                    Want to showcase your works and get hired?
                    <div class="sub header" style="margin-top: 1em">
                        <a href="/register" class="ui green button">Start here <i class="icon arrow right"></i></a>   
                    </div>
                </h4>
            </div>
        @endif
    </div>
</div>

<div class="padded" style="background-color: #eee; margin-top: 2em">
    <div class="ui container">
        <h1 class="ui huge centered header" >
            Explore Our Marketplace
            <div class="sub header">Find the right people for your next project</div>
        </h1>
        <div class="ui divider" style="visibility: hidden;"></div>
    </div>
    @include('includes.popular-categories');
</div>

<div class="padded" style="background-color: #f9f9f9">
    <div class="ui container grid">
        <div class="sixteen wide mobile five wide tablet six wide computer column">
            <img src="{{ asset('public/job-icon.png') }}" alt="Post a job" class="ui centered image" style="max-width: 200px;">
        </div>
        <div class="sixteen wide mobile eleven wide tablet ten wide computer centered column">
            <h2 class="ui header" style="">
                Need To Get Work Done Quickly?
                <div class="sub header">Find the right team members within seconds</div>
            </h2>
            <!-- <div class="ui divider"></div> -->
            <p>
                With over 10,000 works showcased on {{config('app.name')}}, finding the right person to join your team or projects has never been easier.
            </p>
            <p>
                <a href="/people" class="ui basic rounded green button" style="letter-spacing: 1px; font-size: 12px">FIND PEOPLE</a>
                <a href="{{ route('create_task') }}" class="ui rounded green button" style="letter-spacing: 1px; font-size: 12px">POST A JOB</a>
            </p>
        </div>
        <div class="sixteen wide computer column">
            <h4 class="ui centered grey header" style="letter-spacing: 2px">FEATURED USERS</h4>
            <div class="slick-js">
                @each('profile.person', $profiles, 'profile')
            </div>
            @if( !Auth::user() )
                <div class="ui centered grid" style="margin-top: 3em">
                    <a href="/register" class="ui green button">Sign up now <i class="icon arrow right"></i></a>
                </div>
            @endif
        </div>
    </div>
</div>


@include('includes.signup-teaser')

@include('includes.skills');

@endsection
