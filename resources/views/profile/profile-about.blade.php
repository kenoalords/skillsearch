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
