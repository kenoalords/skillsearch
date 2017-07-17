@extends('layouts.app')

@section('title', $profile->first_name . ' ' . $profile->last_name)
@section('metadescription', e(str_limit($profile->bio, 100)))
@section('thumbnail', $profile->getAvatar())
@section('type', 'article')

@section('content')

<div id="profile-back" style="background: url({{ $profile->getUserBackground() }}); background-size: cover">
    <div class="user-background">
    </div>
    <div class="user-meta">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <div style="margin-bottom: 1em">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $profile->getAvatar() }}" width="100" height="100" class="img-circle avatar b-lazy" style="margin-bottom: 0">
                </div>
                <div>
                    <h1 class="small-header">{{ $profile->first_name }} {{ $profile->last_name }} {!! identity_check($profile->getVerified()) !!}</h1>
                    
                    <p><i class="glyphicon glyphicon-map-marker"></i> {{ $profile->location }}</p>
                    <p class="skills-default">
                    @foreach ($profile->skills as $skill)
                        <a href="/search?term={{ urlencode($skill->skill) }}" class="label label-xs label-default">{{ $skill->skill }}</a>
                    @endforeach
                    </p>
                </div>
            </div>
        </div><!-- end container -->
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="clearfix row">

            <div class="">
                <div id="user-menu">
                    <nav>
                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="/{{$profile->user->name}}">Works</a></li>
                            <li role="presentation"><a href="/{{$profile->user->name}}/about">About</a></li>
                            @if($profile->user->instagram()->first())
                            <li role="presentation" class="active"><a href="/{{$profile->user->name}}/instagram">Instagram</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <instagram user="{{$profile->user->name}}"></instagram>
                <ul class="list-inline row">
                    <li><follow username="{{$profile->user->name}}"></follow></li>
                    @if($instagram)
                        <li>
                            <a href="/{{$profile->user->name}}/instagram" class="label btn btn-info btn-xs">
                                <i class="fa fa-instagram"></i>
                                 <span class="bold">My Instagram</span> <span class="thin">Feed</span>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user() && Auth::user()->id !== $profile->user_id)
                        <li><a href="{{ route('hire', ['user' => $profile->user->name] )}}" class="label btn btn-success btn-xs"><i class="fa fa-envelope"></i> Contact Me</a></li>
                    @endif

                    @if(!Auth::user())
                        <li><a href="{{ route('hire', ['user' => $profile->user->name] )}}" class="label btn btn-success btn-xs"><i class="fa fa-envelope"></i> Contact Me</a></li>
                    @endif
                 </ul>
            </div>
        </div>
        
        @if ( count($others) )
            <div class="row padded">
                <h4 class="bold text-center">Similar People</h4>
                <hr>
                @each('profile.person-tag', $others, 'profile')
            </div>
        @endif

    </div>
</div>
@endsection
