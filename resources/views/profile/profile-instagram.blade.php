@extends('layouts.app')

@section('title', $profile['fullname'])
@section('metadescription', e(str_limit($profile['bio'], 100)))
@section('thumbnail', $profile['avatar'])
@section('type', 'article')

@section('content')

<div id="profile-back" style="background: url({{ $profile['background'] }}); background-size: cover">
    <div class="ui container white">
        <div class="ui padded grid">
            <div class="sixteen wide mobile four wide tablet two wide computer column">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $profile['avatar'] }}" class="ui fluid image b-lazy">
            </div>
            <div class="sixteen wide mobile twelve wide tablet fourteen wide computer middle aligned column">
                <h1 class="ui header small-header">
                    {{ $profile['fullname'] }} {!! identity_check($profile['verified']) !!}
                    <div class="sub header"><i class="icon marker"></i>{{ $profile['location'] }}</div>
                </h1>
                
                <div class="ui horizontal relaxed list padded">
                @if($profile['has_instagram'])
                    <a href="/{{$profile['username']}}/instagram" class="ui teal tiny icon labeled button">
                        <i class="icon instagram"></i>
                         <span class="bold">My Instagram</span> <span class="thin">Feed</span>
                    </a>
                @endif
                @if(Auth::user() && Auth::user()->id !== $profile['user_id'])
                    <a href="{{ route('hire', ['user' => $profile['username']] )}}" class="ui green mini icon basic labeled button"><i class="icon envelope"></i> Contact Me</a>
                @endif

                @if(!Auth::user())
                    <a href="{{ route('hire', ['user' => $profile['username']] )}}" class="ui green mini icon basic labeled button"><i class="icon envelope"></i> Contact Me</a>
                @endif
                <div class="item">
                    <follow username="{{$profile['username']}}"></follow>
                    <a href="/{{$profile['username']}}" class="ui basic mini grey icon button">View Profile<i class="icon arrow right"></i></a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="ui container">
    <div class="row">
        <div style="margin-bottom: 3em">
            <div class="ui centered container grid">
                <instagram user="{{$profile['username']}}"></instagram>
            </div>
        </div>
        
        @if ( count($others) )
            <h3 class="ui header">Similar People</h3>
            <div class="ui left aligned grid">
                @each('profile.person-tag', $others, 'profile')
            </div>
        @endif

    </div>
</div>

@include('includes.signup-teaser')
@include('includes.skills')

@endsection
