@extends('layouts.app')

@section('title', ucwords(strtolower($portfolio['title'])) . ' by ' . $portfolio['user_profile']['fullname'] )
@section('metadescription', e(str_limit($portfolio['description'], 100)))
@section('thumbnail', $portfolio['thumbnail'])
@section('type', 'portfolio')

@section('content')
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
                        {{ $portfolio['date'] }}
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
            <div class="portfolio-files" style="margin-top: 2em;">
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
            
            
        
            <div class="profile-social-share">
                <div style="margin: 2em 0" class="wrapper-mobile">
                    <h3 class="title is-4 is-size-5-mobile bold">Like and share</h3>
                    <div class="level is-mobile">
                        <div class="level-left">
                            <div class="level-item">
                                <like-button id="{{$portfolio['uid']}}" likes="{{$portfolio['likes_count']}}" liked="{{$portfolio['has_liked']}}"></like-button>
                            </div>
                            <div class="level-item">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $portfolio['link']['href'] }}" class="facebook social-button" target="_blank"><i class="fa fa-facebook"></i></a>
                            </div>
                            <div class="level-item">
                                <a href="https://twitter.com/intent/tweet?url={{ $portfolio['link']['href'] }}&via=ubanjicreatives&text={{ $portfolio['description'] or 'Community of creative and skilled people in Nigeria. Join us today' }}&hashtags=ubanjicreatives" class="twitter social-button" target="_blank"><i class="fa fa-twitter"></i></a>
                            </div>
                            <div class="level-item">
                                <a href="https://plus.google.com/share?url={{ $portfolio['link']['href'] }}" class="google social-button" target="_blank"><i class="fa fa-google-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <meta itemprop="commentCount" content="{{$portfolio[
                    'comment_count']}}">
                </div>            
            </div>

            </div>
        @endif
    </div>
    <div class="section is-light">
        <div class="container" itemprop="author" itemscope itemtype="http://schema.org/Person">
            
            <div class="media">
                <figure class="media-left">
                    <a href="/{{$portfolio['user']}}" itemprop="url" class="image is-64x64">
                        <img src="{{$portfolio['user_profile']['avatar']}}" alt="{{$portfolio['user_profile']['fullname']}}" class="image is-rounded" itemprop="image">
                    </a>
                </figure>
                
                <div class="media-content">
                    <div class="content">
                        <h3 class="title is-5 bold" style="margin-bottom: 5px;">
                            <a href="/{{$portfolio['user']}}" class="{{ ($portfolio['user_profile']['verified']) ? 'verified' : '' }}" itemprop="url"><span itemprop="name">{{$portfolio['user_profile']['fullname']}}</span></a>
                        </h3>
                        <div class="subtitle is-6"><span itemprop="homeLocation">{{$portfolio['user_profile']['location']}}</span></div>

                        <p itemprop="description">{{ str_limit($portfolio['user_profile']['bio'], 120) }}</p>
                         @if(Auth::user() && Auth::user()->id !== $portfolio['user_id'])
                            <a href="{{ route('make_enquiry', ['user' => $portfolio['user']] )}}" class="button is-info">Make enquiry</a>
                        @endif

                        @if(!Auth::user())
                            <a href="{{ route('make_enquiry', ['user' => $portfolio['user']] )}}" class="button is-info">Make enquiry</a>
                        @endif 
                        <follow username="{{$portfolio['user']}}"></follow>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>
@if($others)
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

<tracker :id="{{ $portfolio['id'] }}" type="portfolio" url="{{ Request::path() }}" tags="{{ $portfolio['skills'] }}"></tracker>
@if($similar)
    <div class="section is-light">
        <div class="container">
            <h3 class="title is-4 bold is-size-5-mobile">Similar Works</h3>
            <div class="columns is-multiline">
                @each('includes.portfolio-with-user', $similar, 'portfolio')
            </div>
        </div>
    </div>
@endif

@include('includes.signup-teaser')
<div class="section">
    <div class="container">
        @include('blog.latest_posts')
    </div>
</div>
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

