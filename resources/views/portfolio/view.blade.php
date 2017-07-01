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
                    <ul class="list-inline">
                        <li><a href="/{{$portfolio['user']}}" class="bold"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="img-circle b-lazy user-avatar" width="24" height="24"> {{$portfolio['user_profile']['fullname']}}</a></li>
                        <li class="pull-right"><follow username="{{$portfolio['user']}}"></follow></li>
                    </ul>
                    <hr>
                    <h1 class="bold">{{ ucwords(strtolower($portfolio['title'])) }}</h1>                    
                    <p>{{$portfolio['description']}}</p>
                    <ul class="list-inline text-muted" style="font-weight: 600; font-size: 12px; margin-top: 1em;">
                        <li><i class="glyphicon glyphicon-eye-open"></i> {{ $portfolio['views'] }} {{ str_plural('View', $portfolio['views'])}}</li>
                        <li> {{ $portfolio['date'] }}</li>
                        <li><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">Link <i class="glyphicon glyphicon-new-window"></i></a></li>
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
            <like-button id="{{$portfolio['uid']}}"></like-button>
            <hr>
            <div>@include('includes.share.portfolio', ['url'=>Request::url()])</div>
            
            @if(!Auth::user())
            <a href="/login" class="btn btn-primary">Login or Register</a> to comment or like
            @endif

            <portfolio-comments uid="{{ $portfolio['uid'] }}"></portfolio-comments>
            @endif

            
        </div>
    </div>

    @if(count($others))
        <div id="showcase" class="other-works col-md-10 col-md-offset-1">
            <div class="row">    
                <div class="col-sm-12">
                    <h4 class="bold">More From {{$portfolio['user_profile']['fullname']}}</h4>
                    <hr>
                </div> 
                @each('includes.portfolio-others', $others, 'portfolio')
            </div>
        </div>
    @endif
</div>
<register-view uid="{{$portfolio['uid']}}"></register-view>
@endsection
