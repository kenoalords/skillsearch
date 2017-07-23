@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Recent Works')

@section('content')
<!-- @include('search-form') -->

<div id="showcase">
    <div class="container text-center">
        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 2em">
            <h1><span class="bold">Recent</span> <span class="thin">Portfolio</span></h1>
            <p>Discover, Share and Hire The Best Hands in Nigeria</p>
            @include('search-form')
        </div>
    </div>
    
    <div class="container padded">
        @each('includes.portfolio-with-user', $portfolios, 'portfolio')
    </div>

    <div class="text-center">
        @include('includes.signup-teaser')
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
