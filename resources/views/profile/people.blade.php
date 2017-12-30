@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Discover, Share and Hire The Best Hands In Nigeria')
@section('title', 'Find People')

@section('content')
 
<div class="ui row">
        <section id="people-banner">
            <div class="ui centered grid">
                <h1 class="ui header" style="margin-bottom: 2em">
                    Search Great Talents
                    <div class="sub header">Find the right people for your job in Nigeria.</div>
                </h1>  
                @include('search-form') 
            </div>           
        </section>

        @if ( count($profiles) )
            <div class="padded" id="peoples-list">
                @each('profile.person-tag', $profiles, 'profile')
            </div>
            <div class="ui center aligned grid" style="margin-bottom: 2em;">
                <a href="#" data-page="1" id="get-more-users" class="ui button">Load more</a>
            </div>
        @endif

        <div class="padded" style="background-color: #f8f8f8; bor">
            <h2 class="ui centered header">Top Categories</h2>
            @include('includes.popular-categories');
        </div>

</div>
@include('includes.signup-teaser')

@include('includes.skills')

@endsection
