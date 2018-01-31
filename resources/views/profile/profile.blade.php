@extends('layouts.app')

@section('title', $profile['fullname'])
@section('metadescription', e(str_limit($profile['bio'], 100)))
@section('thumbnail', $profile['avatar'])
@section('type', 'article')

@section('content')
<div itemscope itemtype="http://schema.org/Person">
    <div id="profile-back" style="background: url({{ $profile['background'] }}); background-size: cover">
        <div class="hero">
            <div class="hero-body has-text-centered">
                <img src="{{ $profile['avatar'] }}" data-src="" class="image is-96x96 is-rounded is-centered">
                <meta itemprop="image" content="{{ $profile['avatar'] }}">
                <!-- title and subtitle -->
                <h1 class="title is-4 has-text-white">
                    <span itemprop="name" class="{{ ($profile['verified']) ? 'verified' : '' }}">{{ $profile['fullname'] }}</span>
                </h1>
                <div class="subtitle has-text-white"><span itemprop="homeLocation">{{ $profile['location'] }}</span></div>
                

                <div class="twelve wide mobile twelve wide tablet fourteen wide computer middle aligned column">
                    
                    <follow username="{{$profile['username']}}"></follow>
                    @if($profile['has_instagram'])
                        <a href="/{{$profile['username']}}/instagram" class="button is-small is-primary">
                            <span class="icon"><i class="fa fa-instagram"></i></span>
                             <span>My Instagram Feed</span>
                        </a>
                    @endif
            </div>
        </div>
    </div>
</div>

<div class="hero">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-10">
                    <h2 class="title is-5">Portfolio</h2>
                    <div class="">
                        @if(count($profile['portfolios']))
                            <div class="columns is-multiline">
                                @each('includes.portfolio-with-user', $profile['portfolios'], 'portfolio')
                            </div>
                        @endif
                        @if(count($portfolios) == 0)
                            <div class="text-center">
                                <h3 class="title is-6 has-text-danger">{{ $profile['first_name'] }} has nothing to show at the moment!</h3>
                            </div>
                        @endif
                    </div>                    
                    
                </div>
            </div>       
        </div>
    </div>
</div>

<div class="hero">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-10">
                    <h2 class="title is-5">Skills</h2>
                    <p>
                        @foreach ($profile['skills'] as $skill)
                            <a href="/search?term={{ urlencode($skill['skill']) }}" class="tag is-primary" itemprop="jobTitle">{{ $skill['skill'] }}</a>
                        @endforeach
                    </p>
                </div>
            </div>       
        </div>
    </div>
</div>

<div class="hero is-light">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-10">
                    <h2 class="title is-5">About</h2>
                    @if($profile['bio'])
                        <p itemprop="description">{{$profile['bio']}}</p>
                    @else
                        <p>{{ $profile['first_name'] }} has nothing to say about themselves!</p>
                    @endif

                    @if(Auth::user() && Auth::user()->id !== $profile['user_id'])
                        <a href="{{ route('contact_request', ['user' => $profile['username']] )}}" class="button is-link">Request Contact</a>
                    @endif

                    @if(!Auth::user())
                        <a href="{{ route('contact_request', ['user' => $profile['username']] )}}" class="button is-link">Request Contact</a>
                    @endif
                    <div style="margin-top: 3em">
                        @include('includes.share.profile', ['url'=>Request::url()])
                    </div>
                </div>
            </div>       
        </div>
    </div>
</div>



@if ( count($others) )
<div class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-10">
                    <h2 class="title is-5">Similar People</h2>
                    <div class="columns is-multiline">
                        @each('profile.person', $others, 'profile')
                    </div>
                </div>
            </div>       
        </div>
    </div>
</div>
@endif

@include('includes.signup-teaser')
@include('includes.skills')


@endsection
