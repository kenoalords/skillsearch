@extends('layouts.app')

@section('title', ucwords(strtolower($portfolio['title'])) . ' by ' . $portfolio['user_profile']['fullname'] )
@section('metadescription', e(str_limit($portfolio['description'], 100)))
@section('thumbnail', $portfolio['thumbnail'])
@section('type', 'portfolio')

@section('content')

<div  class="container">
    <div class="row padded">                
        <div class="col-md-10 col-md-offset-1">

            <div class="clearfix">
                <!-- <div class="col-sm-3">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{$portfolio['thumbnail']}}" alt="{{ $portfolio['title'] }}" class="img-responsive b-lazy">
                </div> -->
                <div class="portfolio-meta">
                    <a href="/{{$portfolio['user']}}" class="bold">
                        <h5 class="bold">
                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="img-circle b-lazy user-avatar" width="24" height="24">
                             {{$portfolio['user_profile']['fullname']}}
                        </h5>
                    </a>
                    <h1 class="bold">{{ ucwords(strtolower($portfolio['title'])) }}</h1>                       
                    <p>{{$portfolio['description']}}</p>
                    <ul class="list-inline" style="font-weight: 600; font-size: 12px; margin-top: 1em;">
                        <li><i class="glyphicon glyphicon-eye-open"></i> {{ $portfolio['views'] }} {{ str_plural('View', $portfolio['views'])}}</li>
                        <li> {{ $portfolio['date'] }}</li>
                        @if($portfolio['url'])
                            <li><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">Link <i class="glyphicon glyphicon-new-window"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            
            @if($portfolio['is_public'] === 0 )
            <div class="alert alert-info">
                <i class="glyphicon glyphicon-eye-close"></i>
                <span>This portfolio is currently set to <strong>Private</strong></span>
            </div>
            @endif

            @if($portfolio['is_public'] === 1 || (Auth::user() && Auth::user()->id === $portfolio['user_id']))
            
            @if($portfolio['type'] === 'images')
                
                @foreach ($files as $file)
                    <div class="portfolio-image-wrapper">
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{asset($file->getFile())}}" alt="{{ $portfolio['title'] }} Image" class="img-responsive whiteCard padding-1 b-lazy">
                    </div>
                @endforeach

            @endif

            @if($portfolio['type'] === 'audio')
                @foreach ($files as $file)
                    <div class="whiteCard">
                        <!-- <audio controls preload>
                            <source src=""></audio>
                        </audio> -->
                        <div id="audio" data-src="{{asset($file->getFile())}}"></div>
                        <hr>
                        <a href="#" class="media-buttons" id="play-audio"><i class="fa fa-play"></i></a>
                        <a href="#" class="media-buttons" id="stop-audio"><i class="fa fa-stop"></i></a>
                    </div>
                @endforeach
            @endif

            @if($portfolio['type'] === 'video')
                @foreach ($files as $file)
                    <video-player video-url="{{$file->getFile()}}"></video-player>
                @endforeach
            @endif
            @if($portfolio['skills'])
            <p class="text-muted">Tags: {!! skill_links($portfolio['skills']) !!}</p>
            @endif
            <ul class="list-inline">
                <li><like-button id="{{$portfolio['uid']}}"></like-button></li>
            </ul>
            <hr>
            <div class="" style="margin-bottom: 2em">
                <div class="media">
                    <div class="media-left">
                        <a href="/{{$portfolio['user']}}">
                            <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="img-circle" width="64" height="64">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 style="margin: 0"><span class="thin text-muted"><em>by</em> </span> <a href="/{{$portfolio['user']}}" class="bold">{{$portfolio['user_profile']['fullname']}}</a></h4>
                        <span class="text-muted"><i class="fa fa-map-marker"></i> {{$portfolio['user_profile']['location']}}</span>
                        <p>{{$portfolio['user_profile']['bio']}}</p>

                        <ul class="list-inline">
                            @if(Auth::user() && Auth::user()->id !== $portfolio['user_id'])
                                <li><a href="{{ route('hire', ['user' => $portfolio['user']] )}}" class="btn btn-success btn-xs" style="padding: 4px 20px"><i class="fa fa-envelope"></i> Contact Me</a></li>
                            @endif

                            @if(!Auth::user())
                                <li><a href="{{ route('hire', ['user' => $portfolio['user']] )}}" class="btn btn-success btn-xs" style="padding: 4px 20px"><i class="fa fa-envelope"></i> Contact Me</a></li>
                            @endif
                            <li><follow username="{{$portfolio['user']}}"></follow></li>
                            <!-- <li><span>{{ $portfolio['user_profile']['following'] }} Following</span></li>
                            <li><span>{{ $portfolio['user_profile']['followers'] }} {{ $portfolio['user_profile']['followers'] > 1 ? 'Follwers' : 'Follower' }}</span></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div style="margin-bottom: 2em">@include('includes.share.portfolio', ['url'=>Request::url()])</div>
            
            @if(count($others))
                <div style="margin: 3em 0">
                    <h4 class="bold">More From {{$portfolio['user_profile']['fullname']}}</h4>
                    <div class="row">    

                        @each('includes.portfolio-others', $others, 'portfolio')
                    </div>
                </div>
            @endif
                        
            @if(!Auth::user())
            <a href="/login" class="btn btn-primary">Login or Register</a> to comment or like
            @endif

            <portfolio-comments uid="{{ $portfolio['uid'] }}" avatar="{{ $avatar }}"></portfolio-comments>
            @endif

            
            @if(count($similar) > 0)
                <h3 class="bold" style="margin-top: 3em;">Similar Works</h3>
                <div class="row">
                    @each('includes.portfolio-others', $similar, 'portfolio')
                </div>
            @endif
        </div>
    </div>

    
</div>
<register-view uid="{{$portfolio['uid']}}"></register-view>
@endsection
