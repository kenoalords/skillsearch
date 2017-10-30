@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Recent Works')

@section('content')
<!-- @include('search-form') -->

<div>
    <div class="ui centered container grid">
        <div class="" style="margin: 4em 0 2em">
            <h1 class="ui header" style="margin-bottom: 1em">Search Portfolio
                <div class="sub header">Discover, Share and Hire The Best Hands in Nigeria</div>
            </h1>
            @include('search-form')
        </div>
    </div>
    <div class="padded">
        <div class="ui divider"></div>
    </div>
    <div>
        <div class="ui centered container grid">
            @each('includes.portfolio-with-user', $portfolios, 'portfolio')
        </div>
    </div>
</div>
<div class="padded"></div>
@include('includes.signup-teaser')
@include('includes.skills')

@endsection
