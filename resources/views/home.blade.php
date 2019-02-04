@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    
    <h2 class="title is-2 bold">Hello {{ $user['first_name'] }}!</h2>
    <p>Welcome to your activity board</p>
    @include('includes.status')
    
    <div class="columns is-multiline user-stats is-mobile">
        <div class="column is-one-quater-desktop is-one-quater-tablet is-half-mobile">
            <div class="stats has-text-centered">
                <h4 class="title is-1 bold is-size-3-mobile">{{ $portfolio_count }}</h4>
                <p><a href="{{ route('portfolio_index') }}">Portfolios</a></p>
            </div>
        </div>
        <div class="column is-one-quater-desktop is-one-quater-tablet is-half-mobile">
            <div class="stats has-text-centered">
                <h4 class="title is-1 bold is-size-3-mobile">{{ $blog_count }}</h4>
                <p><a href="{{ route('blog') }}">Blog posts</a></p>
            </div>
        </div>
        <div class="column is-one-quater-desktop is-one-quater-tablet is-half-mobile">
            <div class="stats has-text-centered">
                <h4 class="title is-1 bold is-size-3-mobile">{{ $subscriber_count }}</h4>
                <p><a href="{{ route('subscribers') }}">Subscribers</a></p>
            </div>
        </div>
        <div class="column is-one-quater-desktop is-one-quater-tablet is-half-mobile">
            <div class="stats has-text-centered">
                <h4 class="title is-1 bold is-size-3-mobile">{{ $user['points'] }}</h4>
                <p><a href="{{ route('points') }}">Points</a></p>
            </div>
        </div>
    </div>
    @if($user['verified_email'] === 0)
        <div class="notification is-danger">
            <div class="title is-6"><span class="icon"><i class="fa fa-envelope"></i></span> Please verify your email address <strong>{{Request::user()->email}}</strong>. <a href="{{route('verify')}}">Resend verification link</a></div>
        </div>
    @endif

    @if(!$user['verified'])
        <div class="notification">
            <div class="title is-6"><span class="icon verified"></span> Verify your identity and increase your ranking instantly and improve your credibility score <a href="{{ route('verify_identity') }}">Verify my identity</a></div>
        </div>
    @endif

    <!-- Portfolio section -->
    @if ( $portfolios )
        <div style="padding: 3em 0">
            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">
                        <h3 class="title is-3 is-size-5-mobile bold">Your recent work</h3>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="{{ route('new_portfolio') }}" class="has-text-weight-bold button is-light">
                            <span class="icon"><i class="fa fa-plus"></i></span> <span>Upload work</span>
                        </a>
                    </div>
                </div>
            </div>
        
            <div class="columns is-multiline is-mobile">
                @each('includes.portfolio-with-user',  $portfolios, 'portfolio')
            </div>
            <a href="{{ route('new_portfolio') }}" class="button is-info big-action-button">Upload work</a>
        </div>
    @else
        <div class="notification is-raised is-white is-padded is-bordered-left">
                <h2 class="title is-1">😎</h2>
                <h3 class="title is-3 is-size-4-mobile bold">Upload your works.</h3>
                <p class="subtitle">Express your creativity using Pictures, Videos and Audio. Upload your work today and start finding new opportunities.</p>
                <p>
                    <a href="{{ route('new_portfolio') }}" class="button is-info big-action-button">Upload work</a>
                </p>
        </div>
        <div id="dashboard-featured">
            @include('includes.featured-portfolios')
        </div>
    @endif


    
    
    <!-- Blog section -->
    @if ( $blogs )
        <div style="padding: 3em 0">
            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">
                        <h3 class="title is-4 is-size-5-mobile bold">Your blog post</h3>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="{{ route('add_blog') }}" class="has-text-weight-bold button is-light">
                            <span class="icon"><i class="fa fa-pencil"></i></span> <span>Write new</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="columns is-multiline">
                @each('blog.partials.blog',  $blogs, 'blog')
            </div>
            <p>
                <a href="{{ route('add_blog') }}" class="button is-info big-action-button">Write something interesting</a>
            </p>
        </div>
    @else
        <!-- <hr style="opacity: .2"> -->
        <div class="notification is-raised is-white is-padded is-bordered-left">
                <h2 class="title is-1">✍🏽</h2>
                <h3 class="title is-3 is-size-4-mobile bold">Write your first blog post.</h3>
                <p class="subtitle">Blogging is a great way to share your ideas, passion and thoughts with the world. It's also a great way to gain recognition that positions you as an expert in your field.</p>
                <p>
                    <a href="{{ route('add_blog') }}" class="button is-info big-action-button">Write something interesting</a>
                </p>
        </div>
        <hr style="opacity: .2">
        @include('blog.latest_posts', ['title'=> 'Latest blog post from users'])
    @endif

    <!-- @if($gmail === true && $invite_status === false) -->
        @include('includes.gmail-invite')
    <!-- @endif -->
    @include('includes.gmail-invite')

    @if(Auth::user()->is_admin === 1)
    <div class="hero is-dark">
        <div class="hero-body has-text-centered">
            <h3 class="title is-4">Send contact invite reminder</h3>
            <send-reminder></send-reminder>
        </div>
    </div>
    @endif
    
@endsection
