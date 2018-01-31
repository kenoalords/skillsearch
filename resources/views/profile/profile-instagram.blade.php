@extends('layouts.app')

@section('title', $profile['fullname'] . ' Instagram Feed')
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
                    <div class="ui horizontal relaxed list padded">
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
</div>

<div class="hero">
    <div class="hero-body">
        <div class="columns is-centered">
            <div class="column is-10">
                <h1 class="title is-4">Instagram feed</h1>
                <div class="columns is-multiline">
                    <instagram user="{{$profile['username']}}"></instagram>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hero is-primary">
    <div class="hero-body">
        @if ( count($others) )
            <div class="columns is-centered">
                <div class="column is-10">
                    <h3 class="title is-5">Similar People</h3>
                    <div class="columns is-multiline">
                        @each('profile.person', $others, 'profile')
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@include('includes.signup-teaser')
@include('includes.skills')

@endsection
