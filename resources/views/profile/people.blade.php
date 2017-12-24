@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Find People')

@section('content')
 
<div class="ui row padded">
        <div class="ui centered grid" style="margin: 2em 0 1em">
            <h1 class="ui header">
                Search Great Talents
                <div class="sub header">Find the right people for your job in Nigeria.</div>
            </h1>   
    		<!-- <p>Find the right people for the Job.</p> -->
        </div>
        @include('search-form')
        <div class="padded">
            <div class="ui divider"></div>
        </div>
        @if ( count($profiles) )
            <div class="" id="peoples-list">
                @each('profile.person-tag', $profiles, 'profile')
            </div>
            <div class="ui center aligned grid" style="margin-top: 2em;">
                <a href="#" data-page="1" id="get-more-users" class="ui button">Load more</a>
            </div>
        @endif
</div>
@include('includes.signup-teaser')

@include('includes.skills')

@endsection
