@extends('layouts.app')

@section('title', ucwords(strtolower($portfolio['title'])) . ' by ' . $portfolio['user_profile']['fullname'] )
@section('metadescription', e(str_limit($portfolio['description'], 100)))
@section('thumbnail', $portfolio['thumbnail'])
@section('type', 'portfolio')

@section('content')

@if($portfolio['is_featured'])
    <!-- <div class="featured-tag big fixed"><i class="icon star"></i></div> -->
@endif
<div class="columns is-marginless is-raised" id="sidebar" itemscope itemtype="http://schema.org/CreativeWork" style="position: relative; background: #fff">
    
    <div class="column is-hidden-desktop" style="">
        <div style="margin: 1em 0;" itemprop="author" itemscope itemtype="http://schema.org/Person">
            <a href="/{{$portfolio['user']}}" class="bold">
                <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="image is-48x48 is-rounded is-inline">
                <span itemprop="name" style="position: relative; top: -16px">{{$portfolio['user_profile']['fullname']}}</span>
            </a>
            <meta itemprop="image" content="{{$portfolio['user_profile']['avatar']}}">
        </div>
        <figure class="image">
            <img src="{{$portfolio['thumbnail']}}" alt="{{$portfolio['title']}}">
        </figure>
        
        <h1 class="title is-3" itemprop="name">{{ ucwords(strtolower($portfolio['title'])) }}</h1> 
                            
        <p itemprop="description">{{($portfolio['description'] != 'undefined') ? $portfolio['description'] : ''}}</p>
        <div class="level is-mobile">
            <div class="level-left">
                <div class="level-item">
                    <span class="icon"><i class="fa fa-eye"></i></span> 
                    <span>{{ $portfolio['views'] }}</span>
                </div>
                <div class="level-item">
                    <span class="icon"><i class="fa fa-calendar"></i></span>
                    <span>{{ $portfolio['date'] }}</span>
                </div>
                <meta itemprop="dateCreated" content="{{ $portfolio['created_at'] }}">
                @if($portfolio['url'])
                    <div class="level-item">
                        <a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">
                            <span>External Link</span> 
                            <span class="icon"><i class="fa fa-sign-out"></i></span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if($portfolio['skills'])
            <p>{!! skill_links($portfolio['skills']) !!}</p> 
        @endif

    </div>
    <div class="column is-9 is-paddingless">
        @if($portfolio['is_public'] === 0 )
        <div class="notification is-danger">
            This portfolio is currently set to <strong class="icon"><i class="fa fa-lock"></i> Private</strong>
        </div>
        @endif

        @if($portfolio['is_public'] === 1 || (Auth::user() && Auth::user()->id === $portfolio['user_id']))
        
            @foreach ($portfolio['files'] as $file)

                @if(in_array($file['file_type'], ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']))
                    <div class="portfolio-image-wrapper" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                        <figure class="image">
                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{$file['file']}}" alt="{{ $portfolio['title'] }} Image" class="b-lazy" itemprop="thumbnail">
                        </figure>
                        <meta itemprop="url" content="{{ $file['file'] }}">
                    </div>  
                @endif
                @if(in_array($file['file_type'], ['audio/wav', 'audio/mp3', 'audio/mpga']))
                    <div id="jquery_jplayer_1" class="jp-jplayer" data-src="{{$file['file']}}" data-title="{{$portfolio['title']}}"></div itemprop="audio" itemscope itemtype="http://schema.org/AudioObject">
                        <meta itemprop="url" content="{{$file['file']}}">
                    <div id="jp_audio_wrapper" class="">
                        <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
                      <div class="jp-type-single" style="text-align: center">
                        <div class="jp-gui jp-interface">
                          <div class="jp-volume-controls">
                            <div class="jp-volume-bar">
                              <div class="jp-volume-bar-value"></div>
                            </div>
                          </div>
                          <div class="jp-controls-holder" style="margin-top: 2em;">
                            <div class="jp-controls ui middle aligned column">
                                <span class="jp-mute ui basic icon circular mini button" role="button" tabindex="0"><i class="icon mute"></i></span>
                                <button class="jp-play ui icon circular huge green basic button" role="button" tabindex="0"><i class="icon play"></i></button>
                                <button class="jp-stop ui icon circular red basic button" role="button" tabindex="0"><i class="icon stop"></i></button>
                                <span class="jp-volume-max ui basic icon circular mini button" role="button" tabindex="0"><i class="icon volume up"></i></span>
                            </div>
                            <div class="jp-progress">
                              <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                              </div>
                            </div>
                            <div class="ui">
                                <div class="jp-current-time ui large grey header" role="timer" aria-label="time" style="margin-top: 1em; margin-bottom: 0">&nbsp;</div>
                                <div class="jp-duration ui red sub header" role="timer" aria-label="duration" style="margin-top: 0;">&nbsp;</div>
                            </div>
                            <div class="jp-toggles" style="display: none;">
                              <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                            </div>
                          </div>
                        </div>
                        <div class="jp-details">
                          <div class="jp-title" aria-label="title">&nbsp;</div>
                        </div>
                        <div class="jp-no-solution">
                          <span>Update Required</span>
                          To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                      </div>
                    </div>
                    </div>
                @endif

                @if(in_array($file['file_type'], ['video/mp4']))
                    <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
                        <video-player video-url="{{$file['file']}}"></video-player> 
                        <meta itemprop="url" content="{{$file['file']}}">
                    </div>
                @endif
            @endforeach

            
        
            <div class="hero is-white">
                <div class="hero-body has-text-centered">
                    <h3 class="title is-3 is-size-5-mobile">Appreciate this work!</h3>
                    <like-button id="{{$portfolio['uid']}}" big="true" likes="{{$portfolio['likes_count']}}" liked="{{$portfolio['has_liked']}}"></like-button>
                    <meta itemprop="commentCount" content="{{$portfolio[
                    'comment_count']}}">
                </div>            
            </div>
        @endif
        <div class="hero">
            <div class="hero-body" itemprop="author" itemscope itemtype="http://schema.org/Person">
                
                <div class="media">
                    <figure class="media-left">
                        <a href="/{{$portfolio['user']}}" itemprop="url" class="image is-64x64">
                            <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="image is-rounded" itemprop="image">
                        </a>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <h3 class="title is-5">
                                <a href="/{{$portfolio['user']}}" class="{{ ($portfolio['user_profile']['verified']) ? 'verified' : '' }} has-text-dark" itemprop="url"><span itemprop="name">{{$portfolio['user_profile']['fullname']}}</span></a>
                            </h3>
                            <div class="subtitle is-6"><span itemprop="homeLocation">{{$portfolio['user_profile']['location']}}</span></div>

                            <p itemprop="description">{{$portfolio['user_profile']['bio']}}</p>
                             @if(Auth::user() && Auth::user()->id !== $portfolio['user_id'])
                                <a href="{{ route('contact_request', ['user' => $portfolio['user']] )}}" class="button is-small is-primary"><i class="fa fa-mail"></i>&nbsp;Request Contact</a>
                            @endif

                            @if(!Auth::user())
                                <a href="{{ route('contact_request', ['user' => $portfolio['user']] )}}" class="button is-small is-primary"><i class="fa fa-phone"></i>&nbsp;Request Contact</a>
                            @endif 
                            <follow username="{{$portfolio['user']}}"></follow>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
        

    </div>
    <div  class="column is-3 is-light is-hidden-touch" style="background: #f5f5f5">
        <div>
            <img src="{{$portfolio['thumbnail']}}" class="image is-responsive" alt="{{ $portfolio['title'] }}" style="margin-bottom: 1em">
            <h1 class="title is-4">{{ ucwords(strtolower($portfolio['title'])) }}</h1> 
                                
            <p itemprop="description">{{($portfolio['description'] != 'undefined') ? $portfolio['description'] : ''}}</p>
            <div class="level is-mobile ">
                <div class="level-left is-size-7">
                    <div class="level-item is-6"><i class="fa fa-eye"></i>&nbsp;{{ $portfolio['views'] }}</div>
                    <div class="level-item is-6"><i class="fa fa-calendar"></i>&nbsp;{{ $portfolio['date'] }}</div>
                    @if($portfolio['url'])
                    <div class="level-item is-6"><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">&nbsp;External Link <i class="icon sign out"></i></a></div>
                    @endif
                </div>
            </div>
            @if($portfolio['skills'])
                <p>{!! skill_links($portfolio['skills']) !!}</p> 
            @endif
            <div class="ui divider" style="visibility: hidden;"></div>
        </div>
    </div>
</div>

<div class="hero">
    <div class="hero-body">
        <div class="columns is-centered is-white">
            <div class="column is-10">
                @if(!Auth::user())
                    <h3 class="title is-5">You must be <a href="/login" class="">logged in</a> to post a comment</h3>
                @endif
                <portfolio-comments uid="{{ $portfolio['uid'] }}" avatar="{{ $avatar }}"></portfolio-comments>

                @if(count($others))
                    <h3 class="title is-6" style="margin-top: 3em">More From {{$portfolio['user_profile']['fullname']}}</h3>
                    <div class="columns is-multiline">    
                        @each('includes.portfolio-with-user', $others, 'portfolio')
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(count($similar) > 0)
    <div class="hero is-primary">
        <div class="hero-body">
            <div class="columns is-centered is-multiline">
                <div class="column is-10">
                    <h3 class="title is-4" style="margin-left: 12px;">Similar Works</h3>
                    @each('includes.portfolio-with-user', $similar, 'portfolio')
                </div>
            </div>
        </div>
    </div>
@endif

@include('includes.signup-teaser')
@include('includes.skills')
<register-view uid="{{$portfolio['uid']}}"></register-view>
@endsection
