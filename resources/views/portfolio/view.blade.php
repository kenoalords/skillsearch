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
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="img-circle b-lazy" width="64" height="64">
            </a>
            <div class="pull-left">
                <h4 class="bold">{{ $portfolio['title'] }}</h4>
                <ul class="list-inline" style="font-weight: 700; font-size: 12px;">
                    <li>by <a href="/{{$portfolio['user']}}">{{$portfolio['user_profile']['fullname']}}</a></li>
                    <li><i class="glyphicon glyphicon-heart"></i> {{ $portfolio['likes_count'] }} {{ str_plural('Like', $portfolio['likes_count'])}}</li>
                    <li><i class="glyphicon glyphicon-eye-open"></i> {{ $portfolio['views'] }} {{ str_plural('View', $portfolio['views'])}}</li>
                    @if($portfolio['url'] !== null)
                        <li><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">Link <i class="glyphicon glyphicon-new-window"></i></a></li>
                    @endif
                    <li> {{ $portfolio['date'] }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row padded">
        <div class="col-md-3">
            <div class="">
                <div>{{$portfolio['description']}}</div>
                @if($portfolio['description'])
                    @if($portfolio['url'] !== null)
                        <p><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">Link <i class="glyphicon glyphicon-new-window"></i></a></p>
                    @endif
                    <hr>
                @endif
                <div>
                    @include('includes.share.portfolio', ['url'=>Request::url()])
                </div>

                <div style="padding: 2em 0">
                    <like-button id="{{$portfolio['uid']}}"></like-button>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">

            @if($portfolio['is_public'] === 0 )
            <div class="alert alert-info">
                <i class="glyphicon glyphicon-eye-close"></i>
                <span>This portfolio is currently set to <strong>Private</strong></span>
            </div>
            @endif

            @if($portfolio['is_public'] === 1 || (Auth::user() && Auth::user()->id === $portfolio['user_id']))
            
            @if($portfolio['type'] === 'images')
                
                @foreach ($files as $file)
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{asset($file->getFile())}}" alt="{{ $portfolio['title'] }} Image" class="img-responsive thumbnail b-lazy">
                @endforeach

            @endif

            @if($portfolio['type'] === 'audio')
                @foreach ($files as $file)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <audio controls preload>
                                <source src="{{asset($file->getFile())}}"></audio>
                            </audio>
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
        <div id="showcase">
            <div class="row">
                <h4 class="bold">Other portfolio items by {{$portfolio['user_profile']['fullname']}}</h4>
                <hr>
            </div> 
            <div class="row">     
                @each('includes.portfolio-others', $others, 'portfolio')
            </div>
        </div>
    @endif
</div>
<register-view uid="{{$portfolio['uid']}}"></register-view>
@endsection
