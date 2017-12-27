@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Recent Works')

@section('content')
<!-- @include('search-form') -->

<div>
    <div class="ui centered container grid">
        <div class="" style="margin: 3em 0 3em">
            <h1 class="ui header" style="margin-bottom: 1em">Recent Works!</h1>
             @include('search-form')
        </div>
    </div>
    <!-- <div class="ui divider" style="padding: .5em 0"></div> -->
    <div>
        <div>
            <portfolio-list></portfolio-list>
        </div>
    </div>
</div>
<div class="padded"></div>
@include('includes.signup-teaser')
@include('includes.skills')

@endsection
