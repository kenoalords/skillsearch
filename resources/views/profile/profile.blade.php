@extends('layouts.app')

@section('title', $profile['fullname'])
@section('metadescription', e(str_limit($profile['bio'], 100)))
@section('thumbnail', $profile['avatar'])
@section('type', 'article')

@section('content')
<div itemscope itemtype="http://schema.org/Person">
    <div id="profile-back" style="background: url({{ $profile['background'] }}); background-size: cover">
        <div class="section">
            <div class="container has-text-centered">
                <img src="{{ $profile['avatar'] }}" data-src="" class="image is-96x96 is-rounded is-centered">
                <meta itemprop="image" content="{{ $profile['avatar'] }}">
                <!-- title and subtitle -->
                <h1 class="title is-4 has-text-white" style="margin-bottom: 7px;">
                    <span itemprop="name" class="{{ ($profile['verified']) ? 'verified' : '' }}">{{ $profile['fullname'] }}</span>
                </h1>
                <div class="subtitle has-text-white"><span itemprop="homeLocation">{{ $profile['location'] }}</span></div>
                <div>
                    @foreach ($profile['skills'] as $skill)
                        <a href="/search?term={{ urlencode($skill['skill']) }}" class="tag is-white" itemprop="jobTitle">{{ $skill['skill'] }}</a>
                    @endforeach
                </div>
                <br>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h2 class="title is-4 bold">Portfolio</h2>
        @if(count($profile['portfolios']))
            <div class="columns is-multiline is-mobile">
                @each('includes.portfolio-with-user', $profile['portfolios'], 'portfolio')
            </div>
        @endif
        @if(count($portfolios) == 0)
            <h3 class="title is-5 has-text-danger">{{ $profile['first_name'] }} has nothing to show at the moment!</h3>
        @endif  
        <hr>
        <h2 class="title is-4 bold">Blog</h2> 
        @if( count($blog) > 0 )
            <div class="columns is-multiline">
                @each('blog.partials.blog', $blog, 'blog')
            </div>
        @else
            <h3 class="title is-5 has-text-danger">{{ $profile['first_name'] }} has not shared any blog post!</h3>
        @endif
    </div>
</div>
<hr>
<div class="section">
    <div class="container">
        <h2 class="title is-4 bold">About</h2>
        @if($profile['bio'])
            <p itemprop="description">{{$profile['bio']}}</p>
        @else
            <p>{{ $profile['first_name'] }} is yet to provide a brief description about themselves!</p>
        @endif
        <follow username="{{$profile['username']}}"></follow> &nbsp;&nbsp;
        @if(Auth::user() && Auth::user()->id !== $profile['user_id'])
            <a href="{{ route('make_enquiry', ['user' => $profile['username']] )}}" class="button is-primary">
                <span class="icon"><i class="fa fa-envelope"></i></span> <span>Contact</span>
            </a>
        @endif

        @if(!Auth::user())
            <a href="{{ route('make_enquiry', ['user' => $profile['username']] )}}" class="button is-primary">
                <span class="icon"><i class="fa fa-envelope"></i></span> <span>Contact</span>
            </a>
        @endif
        <div style="margin-top: 3em">
            @include('includes.share.profile', ['url'=>Request::url(), 'text'=>$profile['bio']])
        </div>    
    </div>
</div>



@if ( count($others) )
<div class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-10">
                    <h2 class="title is-5">Similar People</h2>
                    <div class="columns is-multiline">
                        @each('profile.person', $others, 'profile')
                    </div>
                </div>
            </div>       
        </div>
    </div>
</div>
@endif

@include('includes.signup-teaser')
@include('includes.skills')

@push('script')
<script>
  fbq('track', 'ViewContent', {
    content_type: 'Profile',
  });
</script>
@endpush

@endsection
