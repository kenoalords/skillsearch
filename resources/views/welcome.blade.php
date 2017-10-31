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
            <h1><span class="beast">Showcase &amp; Discover</span> <br>Creative People in Nigeria</h1>          
        </div>
    </div>
</div>

<div id="home-search" class="padded">
    @include('search-form')
    
</div>
@if(!Auth::user())
    <p style="text-align: center; margin-top: 2em; font-weight: bold">Want to showcase your creative works? <a href="/register" style="font-weight: bold">Start Here.</a></p>
    @endif
<div id="showcase">
    <div class="ui container">
        <div class="ui centered grid">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>
        <div class="ui centered container grid" style="margin: 2em !important;">
            <a href="/work" class="ui button green">Discover more work</a>
        </div>
        
    </div>
</div>


@include('includes.signup-teaser')

@include('includes.skills');

@endsection
