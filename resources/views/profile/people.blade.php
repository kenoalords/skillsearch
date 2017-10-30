@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Find People')

@section('content')
 
<div class="ui row padded">
        <div class="ui centered grid" style="margin: 2em 0 1em">
            <h1 class="ui header">
                Search People
                <div class="sub header">Find the right people for your job.</div>
            </h1>   
    		<!-- <p>Find the right people for the Job.</p> -->
        </div>
        @include('search-form')
        <div class="padded">
            <div class="ui divider"></div>
        </div>
        @if ( count($profiles) )
            <div class="">
                @each('profile.person-tag', $profiles, 'profile')
            </div>
        @endif
</div>
@include('includes.signup-teaser')

@include('includes.skills')

@endsection
