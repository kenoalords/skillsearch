@extends('layouts.app')

@section('title', $profile['fullname'])
@section('metadescription', e(str_limit($profile['bio'], 100)))
@section('thumbnail', $profile['avatar'])
@section('type', 'article')

@section('content')
<div itemscope itemtype="http://schema.org/Person">
<div id="profile-back" style="background: url({{ $profile['background'] }}); background-size: cover">
    <div class="ui container white">
        <div class="ui padded grid">
            <div class="sixteen wide mobile four wide tablet two wide computer column">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $profile['avatar'] }}" class="ui fluid image b-lazy">
                <meta itemprop="image" content="{{ $profile['avatar'] }}">
            </div>
            <div class="sixteen wide mobile twelve wide tablet fourteen wide computer middle aligned column">
                <h1 class="ui header small-header">
                    <span itemprop="name">{{ $profile['fullname'] }}</span> {!! identity_check($profile['verified']) !!} 
                    <div class="sub header"><i class="icon marker"></i><span itemprop="homeLocation">{{ $profile['location'] }}</span></div>
                </h1>
                <follow username="{{$profile['username']}}" class="right floated"></follow>
                <div class="ui horizontal relaxed list padded">
                @if($profile['has_instagram'])
                    <a href="/{{$profile['username']}}/instagram" class="ui teal mini icon labeled button">
                        <i class="icon instagram"></i>
                         <span class="bold">My Instagram</span> <span class="thin">Feed</span>
                    </a>
                @endif
                
                <div class="item">
                    
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="ui container white">
    <div class="white-boxed">
        <h2 class="ui grey header">Skills</h2>
        <p>
        @foreach ($profile['skills'] as $skill)
            <a href="/search?term={{ urlencode($skill['skill']) }}" class="ui medium circular label skill" itemprop="jobTitle">{{ $skill['skill'] }}</a>
        @endforeach
        </p>
    </div>
</div>

<br>

<div class="ui container white">
    <div class="white-boxed">
        <h2 class="ui grey header">About</h2>
        @if($profile['bio'])
            <p itemprop="description">{{$profile['bio']}}</p>
        @else
            <p>{{ $profile['first_name'] }} has nothing to say about themselves!</p>
        @endif

        @if(Auth::user() && Auth::user()->id !== $profile['user_id'])
            <a href="{{ route('contact_request', ['user' => $profile['username']] )}}" class="ui grey icon labeled green button"><i class="icon mail"></i> Request Contact</a>
        @endif

        @if(!Auth::user())
            <a href="{{ route('contact_request', ['user' => $profile['username']] )}}" class="ui grey icon labeled green button"><i class="icon mail"></i> Request Contact</a>
        @endif

    </div>
</div>

<br>

<div class="ui container">
    
    <div class="white-boxed">
        
        <h2 class="ui grey header">Portfolio</h2>
        <div class="">
            @if(count($profile['portfolios']))
                <div class="ui grid">
                    @each('includes.portfolio-with-user', $profile['portfolios'], 'portfolio')
                </div>
            @endif
            @if(count($portfolios) == 0)
                <div class="text-center">
                    <h1><i class="fa fa-frown-o"></i></h1>
                    <p>{{ $profile['first_name'] }} has nothing to show at the moment!</p>
                </div>
            @endif

            
        </div>
        <div class="ui divider" style="opacity: 0"></div>
        
        <div>
            @include('includes.share.profile', ['url'=>Request::url()])
        </div>
    </div>
</div>
</div>
@if ( count($others) )
    <div class="ui container padded">
        <h2 class="ui medium header">Similar People</h2>
        <div class="ui divider"></div>
        @each('profile.person-tag', $others, 'profile')
    </div>
@endif

@include('includes.signup-teaser')
@include('includes.skills')


@endsection
