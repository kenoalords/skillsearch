@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row padded">
        
        <div class="col-md-10 col-md-offset-1">
            @if($portfolio['is_public'] === 0)
            <div class="alert alert-info">
                <i class="glyphicon glyphicon-eye-close"></i>
                <span>This portfolio is currently set to <strong>Private</strong>. Only you can view it.</span>
            </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <img src="{{asset($portfolio['thumbnail'])}}" alt="" class="img-circle img-responsive">
                </div>
                <div class="col-md-9">
                    
                    <h3 class="bold">{{ $portfolio['title'] }}</h3>
                    <ul class="list-inline" style="font-weight: 700; font-size: 12px;">
                        <li>
                            <div class="clearfix">
                                <a href="/{{$portfolio['user']}}">
                                    <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="img-circle" width="24" height="24">
                                </a>
                                <a href="/{{$portfolio['user']}}">
                                    {{$portfolio['user_profile']['fullname']}}
                                </a>
                            </div>
                        </li>
                        <li><i class="glyphicon glyphicon-heart"></i> {{ $portfolio['likes_count'] }} {{ str_plural('Like', $portfolio['likes_count'])}}</li>
                        <li> {{ $portfolio['date'] }}</li>
                        <li><i class="glyphicon glyphicon-eye-open"></i> {{ $portfolio['views'] }} {{ str_plural('View', $portfolio['views'])}}</li>
                        @if($portfolio['url'] !== '')
                            <li><a href="{{$portfolio['url']}}" target="_blank" class="bold">Link <i class="glyphicon glyphicon-new-window"></i></a></li>
                        @endif
                    </ul>
                    <p>{{ $portfolio['description'] }}</p>

                    <follow username="{{$portfolio['user']}}"></follow>  
                </div>
            </div>
            
            <hr>
            @if($portfolio['type'] === 'images')
                
            @foreach ($files as $file)
                <img src="{{asset($file->getFile())}}" alt="{{ $portfolio['title'] }} Image" class="img-responsive thumbnail">
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

            <div style="padding: 2em 0">
                <like-button id="{{$portfolio['uid']}}"></like-button>
            </div>
            
            @if(!Auth::user())
            <a href="/login" class="btn btn-primary">Login or Register</a> to comment or like
            @endif

            <portfolio-comments uid="{{ $portfolio['uid'] }}"></portfolio-comments>
        </div>
    </div>

    @if(count($others))
        <div class="row" id="showcase">
            <h4 class="thin text-center">Other portfolio items by {{$portfolio['user_profile']['fullname']}}</h4>
            <hr>
            @each('includes.portfolio', $others, 'portfolio')
        </div>
    @endif
</div>
<register-view uid="{{$portfolio['uid']}}"></register-view>
@endsection
