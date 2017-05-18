@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Recent Works')

@section('content')
<!-- @include('search-form') -->
@include('search-form')
<div id="showcase">
    <div class="text-center">
        <h1 class="bold medium-header">Recent Works</h1>
        <p>Discover, Share and Hire The Best Hands in Nigeria</p>
        <!-- <p><a href="/profile/portfolio/add" class="btn btn-primary"><i class="fa fa-briefcase"></i> Submit Your Work</a></p> -->
    </div>
    
    <hr>
    <div class="container-fluid">
        @each('includes.portfolio-with-user', $portfolios, 'portfolio')
    </div>
    <hr>
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
