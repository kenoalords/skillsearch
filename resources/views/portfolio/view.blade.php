@extends('layouts.app')

@section('title', ucwords(strtolower($portfolio['title'])) . ' by ' . $portfolio['user_profile']['fullname'] )
@section('metadescription', e(str_limit($portfolio['description'], 100)))
@section('thumbnail', $portfolio['thumbnail'])
@section('type', 'portfolio')

@section('content')

@if($portfolio['is_featured'])
    <!-- <div class="featured-tag big fixed"><i class="icon star"></i></div> -->
@endif
<div  itemscope itemtype="http://schema.org/CreativeWork" style="position: relative; background: #fff">
    
    <div class="section is-dark">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-4">
                    <figure class="image">
                        <img src="{{$portfolio['thumbnail']}}" alt="{{$portfolio['title']}}">
                    </figure>
                </div>
                <div class="column is-8">
                    <div itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <a href="/{{$portfolio['user']}}" class="portfolio-avatar">
                            <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="image is-24x24 is-rounded is-inline">
                            <span itemprop="name">{{$portfolio['user_profile']['fullname']}}</span>
                        </a>
                        <meta itemprop="image" content="{{$portfolio['user_profile']['avatar']}}">
                        <meta itemprop="dateCreated" content="{{ $portfolio['created_at'] }}">
                    </div>
                    <h1 class="title is-3 is-size-4-mobile" itemprop="name">{{ ucwords(strtolower($portfolio['title'])) }}</h1> 
                    <div class="portfolio-meta">
                        {{ $portfolio['views'] }} views, posted {{ $portfolio['date'] }}
                    </div>
                    <p itemprop="description">{{($portfolio['description'] != 'undefined') ? $portfolio['description'] : ''}}</p>
                    @if($portfolio['skills'])
                        <p>{!! skill_links($portfolio['skills']) !!}</p> 
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    <div class="container">
        @if($portfolio['is_public'] === 0 )
        <div class="notification is-danger">
            This portfolio is currently set to <strong class="icon"><i class="fa fa-lock"></i> Private</strong>
        </div>
        @endif

        @if($portfolio['is_public'] === 1 || (Auth::user() && Auth::user()->id === $portfolio['user_id']))
            <div class="section portfolio-files">
            @foreach ($portfolio['files'] as $file)

                @if(in_array($file['file_type'], ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']))
                    <div class="portfolio-image-wrapper card" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                        <figure class="image">
                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=" data-src="{{$file['file']}}" alt="{{ $portfolio['title'] }} Image" class="b-lazy" itemprop="thumbnail">
                        </figure>
                        <meta itemprop="url" content="{{ $file['file'] }}">
                    </div>  
                @endif
                @if(in_array($file['file_type'], ['audio/wav', 'audio/mp3', 'audio/mpga']))
                    <div class="card">
                        <audio src="{{$file['file']}}" controls></audio>
                    </div>
                @endif

                @if(in_array($file['file_type'], ['video/mp4']))
                    <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject" class="card">
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
                            <h3 class="title is-5 bold">
                                <a href="/{{$portfolio['user']}}" class="{{ ($portfolio['user_profile']['verified']) ? 'verified' : '' }} has-text-dark" itemprop="url"><span itemprop="name">{{$portfolio['user_profile']['fullname']}}</span></a>
                            </h3>
                            <div class="subtitle is-6"><span itemprop="homeLocation">{{$portfolio['user_profile']['location']}}</span></div>

                            <p itemprop="description">{{$portfolio['user_profile']['bio']}}</p>
                             @if(Auth::user() && Auth::user()->id !== $portfolio['user_id'])
                                <a href="{{ route('make_enquiry', ['user' => $portfolio['user']] )}}" class="button is-small is-info">Make enquiry</a>
                            @endif

                            @if(!Auth::user())
                                <a href="{{ route('make_enquiry', ['user' => $portfolio['user']] )}}" class="button is-small is-info">Make enquiry</a>
                            @endif 
                            <follow username="{{$portfolio['user']}}"></follow>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
@if(count($others))
<div class="section is-white">
    <div class="container">
        <h3 class="title is-5 bold">More From {{$portfolio['user_profile']['fullname']}}</h3>
        <div class="columns is-multiline is-mobile">    
            @each('includes.portfolio-with-user', $others, 'portfolio')
        </div>
    </div>
</div>
@endif

<div class="hero is-white">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered is-white">
                <div class="column is-10">
                    @if(!Auth::user())
                        <div class="notification is-danger">You must be <a href="/login" class="">logged in</a> to post a comment</div>
                    @endif
                    <portfolio-comments uid="{{ $portfolio['uid'] }}" avatar="{{ $avatar }}"></portfolio-comments>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($similar) > 0)
    <div class="hero is-primary">
        <div class="hero-body">
            <div class="columns is-centered is-multiline">
                <div class="column is-10">
                    <h3 class="title is-4">Similar Works</h3>
                    <div class="columns is-multiline is-mobile">
                        @each('includes.portfolio-with-user', $similar, 'portfolio')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@include('includes.signup-teaser')
@include('includes.skills')
<register-view uid="{{$portfolio['uid']}}"></register-view>
@push('script')
<script>
  fbq('track', 'ViewContent', {
    content_type: 'Portfolio',
  });
</script>
@endpush
@endsection

