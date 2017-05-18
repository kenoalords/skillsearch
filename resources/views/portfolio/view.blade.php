@extends('layouts.app')

@section('title', $portfolio['user_profile']['fullname'] . ' Portfolio')
@section('metadescription', e(str_limit($portfolio['description'], 100)))
@section('thumbnail', $portfolio['thumbnail'])
@section('type', 'portfolio')

@section('content')


<div id="user-badge" class="">
    <div class="container">
        <div class="col-md-12">
            <a href="/{{$portfolio['user']}}" class="pull-left" style="margin-right: 1em">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="img-circle b-lazy user-avatar" width="64" height="64">
            </a>
            <div class="pull-left portfolio-meta">
                <h4 class="bold">{{ ucwords(strtolower($portfolio['title'])) }}</h4>
                <p>by <a href="/{{$portfolio['user']}}">{{$portfolio['user_profile']['fullname']}}</a></p>
            </div>
            <div class="pull-right portfolio-actions">
                <a href="/{{$portfolio['user']}}/hire" class="btn btn-success"><i class="fa fa-envelope"></i> Hire</a>
                <like-button id="{{$portfolio['uid']}}"></like-button>
            </div>
        </div>
    </div>
</div>
<div id="portfolio" class="container">
    <div class="row padded">
        <div class="col-sm-3" id="portfolio-wrapper">
            <div class="">
                <div class="wrapper">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{$portfolio['thumbnail']}}" alt="{{$portfolio['title']}}" class="img-responsive b-lazy">
                    <div class="white-boxed">
                        <p>{{$portfolio['description']}}</p>
                        <ul class="list-inline" style="font-weight: 600; font-size: 12px; margin-top: 1em;">
                            <li><i class="glyphicon glyphicon-eye-open"></i> {{ $portfolio['views'] }} {{ str_plural('View', $portfolio['views'])}}</li>
                            <li> {{ $portfolio['date'] }}</li>
                        </ul>
                        @if($portfolio['description'])
                            @if($portfolio['url'] !== null)
                                <p><small><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">Link <i class="glyphicon glyphicon-new-window"></i></a></small></p>
                            @endif
                        @endif
                        <p><follow username="{{$portfolio['user']}}"></follow></p>
                        <like-button id="{{$portfolio['uid']}}" class="block-button"></like-button>
                        <hr>
                        <div>
                            @include('includes.share.portfolio', ['url'=>Request::url()])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-9">

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
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{asset($file->getFile())}}" alt="{{ $portfolio['title'] }} Image" class="img-responsive thumbnail b-lazy">
                    </div>
                @endforeach

            @endif

            @if($portfolio['type'] === 'audio')
                @foreach ($files as $file)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <!-- <audio controls preload>
                                <source src=""></audio>
                            </audio> -->
                            <div id="audio" data-src="{{asset($file->getFile())}}"></div>
                            <hr>
                            <a href="#" class="media-buttons" id="play-audio"><i class="fa fa-play"></i></a>
                            <a href="#" class="media-buttons" id="stop-audio"><i class="fa fa-stop"></i></a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if($portfolio['type'] === 'video')
                @foreach ($files as $file)
                    <video-player video-url="{{$file->getFile()}}"></video-player>
                @endforeach
            @endif


            
            @if(!Auth::user())
            <a href="/login" class="btn btn-primary">Login or Register</a> to comment or like
            @endif

            <portfolio-comments uid="{{ $portfolio['uid'] }}"></portfolio-comments>
            @endif

            
        </div>
    </div>

    @if(count($others))
        <div id="showcase" class="other-works">
            <div class="row">    
                <div class="col-sm-12">
                    <h4 class="thin">Other works by {{$portfolio['user_profile']['fullname']}}</h4>
                    <hr>
                </div> 
                @each('includes.portfolio-others', $others, 'portfolio')
            </div>
        </div>
    @endif
</div>
<register-view uid="{{$portfolio['uid']}}"></register-view>
@endsection
