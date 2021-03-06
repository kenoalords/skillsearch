@extends('layouts.app')

@section('title', ucwords(strtolower($portfolio['title'])) . ' by ' . $portfolio['user_profile']['fullname'] )
@section('metadescription', e(str_limit($portfolio['description'], 100)))
@section('thumbnail', $portfolio['thumbnail'])
@section('type', 'portfolio')

@section('content')

<div id="" style="margin-top: 3.4em;">
    <div class="ui">
        <div class="ui padded grid row" id="sidebar" itemscope itemtype="http://schema.org/CreativeWork" style="position: relative;">
            @if($portfolio['is_featured'])
            <div class="featured-tag big fixed"><i class="icon star"></i></div>
            @endif
            <div class="sixteen wide mobile only column" style="background: #f9f9f9; box-shadow: 0 1px 6px rgba(2,2,2,.1); border-bottom: 1px solid #ddd;">
                <div style="margin: 1em 0;" itemprop="author" itemscope itemtype="http://schema.org/Person">
                    <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="ui avatar image"> <a href="/{{$portfolio['user']}}" class="bold"><span itemprop="name">{{$portfolio['user_profile']['fullname']}}</span></a>
                    <meta itemprop="image" content="{{$portfolio['user_profile']['avatar']}}">
                </div>
                <img src="{{$portfolio['thumbnail']}}" alt="{{$portfolio['title']}}" class="ui fluid image">
                <h1 class="ui header" itemprop="name">{{ ucwords(strtolower($portfolio['title'])) }}</h1> 
                                    
                <p itemprop="description">{{($portfolio['description'] != 'undefined') ? $portfolio['description'] : ''}}</p>
                <div class="ui mini divided grey horizontal list bold">
                    <div class="item"><i class="icon eye"></i> {{ $portfolio['views'] }}</div>
                    <div class="item"><i class="icon calendar"></i>{{ $portfolio['date'] }}</div>
                    <meta itemprop="dateCreated" content="{{ $portfolio['created_at'] }}">
                    @if($portfolio['url'])
                        <div class="item"><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">External Link <i class="icon sign out"></i></a></div>
                    @endif
                </div>
                @if($portfolio['skills'])
                    <p>{!! skill_links($portfolio['skills']) !!}</p> 
                @endif

            </div>
            <div class="sixteen wide mobile twelve wide tablet twelve wide computer column" style="background: #fff;box-shadow: 0 1px 16px rgba(2,2,2,.1); position: relative; z-index: 9; border-right: 1px solid #ddd">
                @if($portfolio['is_public'] === 0 )
                <div class="ui warning mini icon message" style="margin-bottom: 2.5em">
                    <i class="icon lock"></i>
                    <div class="content">
                        <div class="header">This portfolio is currently set to <strong>Private</strong></div>
                    </div>
                </div>
                @endif

                @if($portfolio['is_public'] === 1 || (Auth::user() && Auth::user()->id === $portfolio['user_id']))
                
                    @foreach ($portfolio['files'] as $file)

                        @if(in_array($file['file_type'], ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']))
                            <div class="portfolio-image-wrapper" style="margin: -1rem -1rem 2em" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{$file['file']}}" alt="{{ $portfolio['title'] }} Image" class="ui fluid image b-lazy" itemprop="thumbnail">
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

                    
                
                    <div class="ui centered one column grid padded" >
                        <div class="column center aligned">
                            <h3 class="ui header">Appreciate this work!</h3>
                        </div>
                        <like-button id="{{$portfolio['uid']}}" big="true" likes="{{$portfolio['likes_count']}}" liked="{{$portfolio['has_liked']}}"></like-button>
                        <meta itemprop="commentCount" content="{{$portfolio[
                        'comment_count']}}">
                    </div>
                @endif
                <div class="white-boxed" style="margin: 3em -1rem -1rem; background: rgba(247,247,247,1); border-top: 1px solid #ddd; border-bottom: 1px solid #ddd">
                    <div class="ui unstackable items" style="margin: 1em 0 2em" itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <div class="item">
                            <div class="ui tiny image">
                                <a href="/{{$portfolio['user']}}" itemprop="url">
                                    <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="avatar" itemprop="image">
                                </a>
                            </div>
                            <div class="content">
                                <h3 class="ui header">
                                    <a href="/{{$portfolio['user']}}" class="bold" itemprop="url"><span itemprop="name">{{$portfolio['user_profile']['fullname']}}</span></a>
                                    <div class="sub header"><i class="icon marker"></i><span itemprop="homeLocation">{{$portfolio['user_profile']['location']}}</span></div>
                                </h3>
                                <p itemprop="description">{{$portfolio['user_profile']['bio']}}</p>

                                <div class="ui horizontal list">
                                    
                                    @if(Auth::user() && Auth::user()->id !== $portfolio['user_id'])
                                        <div class="item"><a href="{{ route('contact_request', ['user' => $portfolio['user']] )}}" class="ui icon labeled mini green button"><i class="icon mail"></i>Request Contact</a></div>
                                    @endif

                                    @if(!Auth::user())
                                        <div class="item"><a href="{{ route('contact_request', ['user' => $portfolio['user']] )}}" class="ui icon labeled mini green button"><i class="icon phone"></i>Request Contact</a></div>
                                    @endif    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="">
                    @if(count($others))
                        <div style="margin: 3em 0">
                            <h3 class="ui header">More From {{$portfolio['user_profile']['fullname']}}</h3>
                            <div class="ui grid">    
                                @each('includes.portfolio-with-user', $others, 'portfolio')
                            </div>
                        </div>
                    @endif
                </div>

                <div class="ui divider"></div>
                
                <div class="ui centered grid">
                    <div class="sixteen wide mobile twelve wide tablet ten wide computer column">
                        <div class="">
                            @if(!Auth::user())
                                <h3 class="ui header">You must be <a href="/login" class="">logged in</a> to post a comment</h3>
                            @endif

                            <portfolio-comments uid="{{ $portfolio['uid'] }}" avatar="{{ $avatar }}"></portfolio-comments>
                            
                        </div>
                    </div>
                </div>

                <div class="ui grid">
                    @if(count($similar) > 0)
                        <div class="column">
                            <h3 class="ui header">Similar Works</h3>
                            <div class="ui grid">
                                @each('includes.portfolio-with-user', $similar, 'portfolio')
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div  class="four wide tablet only four wide computer only fixed column" style="background: #f9f9f9; box-shadow: 0 1px 6px rgba(2,2,2,.1); border-bottom: 1px solid #ddd;">
                <div class="ui sticky">
                    <div style="margin-bottom: 1em;">
                        <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="ui avatar image"> <a href="/{{$portfolio['user']}}" class="bold">{{$portfolio['user_profile']['fullname']}}</a>
                        <follow username="{{$portfolio['user']}}" class="right floated"></follow>
                    </div>
                    <img src="{{$portfolio['thumbnail']}}" class="ui fluid image">
                    <h1 class="ui medium header">{{ ucwords(strtolower($portfolio['title'])) }}</h1> 
                                        
                    <p itemprop="description">{{($portfolio['description'] != 'undefined') ? $portfolio['description'] : ''}}</p>
                    <div class="ui mini divided grey horizontal list bold">
                        <div class="item"><i class="icon eye"></i> {{ $portfolio['views'] }}</div>
                        <div class="item"><i class="icon calendar"></i>{{ $portfolio['date'] }}</div>
                        @if($portfolio['url'])
                            <div class="item"><a href="{{route('external_link', ['url'=>$portfolio['url']])}}" target="_blank" class="bold">External Link <i class="icon sign out"></i></a></div>
                        @endif
                    </div>
                    @if($portfolio['skills'])
                        <p>{!! skill_links($portfolio['skills']) !!}</p> 
                    @endif
                    <div class="ui divider" style="visibility: hidden;"></div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
@include('includes.signup-teaser')
@include('includes.skills')
<register-view uid="{{$portfolio['uid']}}"></register-view>
@endsection
