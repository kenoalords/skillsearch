@extends('layouts.app')

@section('title', $profile->first_name . ' ' . $profile->last_name)
@section('metadescription', e(str_limit($profile->bio, 100)))
@section('thumbnail', $profile->getAvatar())
@section('type', 'article')

@section('content')

<div id="profile-back">
    <div class="user-background">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+ip1sAAAAASUVORK5CYII=" data-src="{{ $profile->getUserBackground() }}" class="b-lazy" alt="{{ $profile->first_name }} {{ $profile->last_name }}">
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="clearfix row">
            <div class="col-md-3">
                <div class="white-boxed">
                    <div class="text-center">
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
                    <br>
                    <div>
                        <p><follow username="{{$name}}"></follow></p>
                        
                        @if(Auth::user() && Auth::user()->id !== $profile->user_id)
                            <a href="{{ route('hire', ['user' => $name] )}}" class="btn btn-success btn-sm btn-block"><i class="fa fa-envelope"></i> Hire</a>
                        @endif

                        @if(!Auth::user())
                            <a href="{{ route('hire', ['user' => $name] )}}" class="btn btn-success btn-sm btn-block"><i class="fa fa-envelope"></i> Hire</a>
                        @endif
                     </div>
                </div>
            </div>

            <div class="col-md-9">
                <div id="user-menu">
                    <nav>
                        <ul class="nav nav-tabs">
                            <li role="presentation"><a href="/{{$name}}">Works</a></li>
                            <li role="presentation" class="active"><a href="/{{$name}}/about">About</a></li>
                            @if($profile->user->instagram()->first())
                            <li role="presentation"><a href="/{{$name}}/instagram">Instagram</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="">
                    @if($profile->bio)
                        {{$profile->bio}}
                    @else
                        <div class="text-center">
                            <h1><i class="fa fa-frown-o"></i></h1>
                            <p>{{ $profile->first_name }} has nothing to show at the moment!</p>
                        </div>
                    @endif
                    
                    @if($instagram)
                        <p style="margin-top: 1em">
                            <a href="/{{$name}}/instagram" class="btn btn-info">
                                <i class="fa fa-instagram"></i>
                                 <span class="bold">My Instagram</span> <span class="thin">Feed</span>
                            </a>
                        </p>
                    @endif
                </div>
                <div>
                    @include('includes.share.profile', ['url'=>Request::url()])
                </div>
            </div>
            
            @if(count($others) > 0)
            <div id="others" class="col-md-12 padded">
                <div class="container-fluid">
                    <h4 class="text-center">More People</h4>
                    <hr>
                </div>
                <div class="container-fluid">
                    @each('includes.profile-tag', $others, 'profile')
                </div>
            </div>
            @endif
            
        </div>

        

        

    </div>
</div>
@endsection
