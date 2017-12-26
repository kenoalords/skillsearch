@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Recent Works')

@section('content')
<!-- @include('search-form') -->

<div>
    <div class="ui centered container grid">
        <div class="" style="margin: 4em 0 0em">
            <h1 class="ui header">Portfolio Showcase
                <!-- <div class="sub header">Discover, Share and Hire The Best Hands in Nigeria</div> -->
            </h1>
            {{-- @include('search-form') --}}
        </div>
    </div>
    <div class="padded">
        <div class="ui divider"></div>
    </div>
    <div>
        <div class="ui container grid">
            <portfolio-list></portfolio-list>
        </div>
    </div>
</div>
<div class="padded"></div>
@include('includes.signup-teaser')
@include('includes.skills')

@endsection
