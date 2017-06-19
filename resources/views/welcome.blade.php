@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Home')
@section('metadescription', 'Showcase your skills, find latest jobs and get hired on Nigeria preferred skills promotion platform')

@section('content')
<!-- @include('search-form') -->
<div id="hero">
    <div class="container">
        <div class="col-md-8 col-md-offset-2 text-center">
            <h1 class="thin" style="font-size: 1.5em">Showcase &amp; Discover Skilled People in Nigeria.</h1>
            <br>
            <p>
                <a href="/people" class="btn btn-primary bold">Discover People</a>
            </p>
                        
        </div>
    </div>
</div>

<div id="showcase">
    <div class="row">
        @each('includes.portfolio-with-user', $portfolios, 'portfolio')
    </div>
    <div class="text-center" style="margin-bottom: 2em;">
        <a href="/work" class="btn btn-primary">Discover more work</a>
    </div>
    @if(!Auth::user())
    <hr>
    <div class="text-center padded">
        @include('includes.signup-teaser')
    </div>
    @endif
</div>

<div id="how">
    <div class="container text-center padded">
        <h2>How it works</h2>
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

@if($skills->count())
<div id="categories">
    <div class="container padded">
        <h4 class="bold">Browse top skills</h4>
        <hr>
        @foreach($skills as $skill)
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
            <a href="/search?term={{ urlencode($skill->skill) }}"> {{ $skill->skill }} </a>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection
