@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    @include('includes.dashboard-menu')
    <!-- <h2 class="title is-2 is-size-5-mobile bold">Hello {{ $user['first_name'] }}!</h2> -->
    <div class="modal push-notification-modal">
        <div class="modal-background"></div>
        <div class="modal-body">
            <div class="card">
                <div class="card-content has-text-centered">
                    <h1 class="title is-1">🔔</h1>
                    <h3 class="title is-4 bold">
                        Don't miss important activities and updates on your page.
                    </h3>
                    <p>
                        <a href="#" class="push-notification button is-fullwidth-mobile is-danger big-action-button"><span class="icon"><i class="fa fa-bell"></i></span> <span>Enable notification</span> </a>
                    </p>
                    <p>
                        <a href="#" class="close-push-notification-modal has-text-grey">I'll do this later</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    @include('includes.status')
    

    <!-- <div class="notification is-raised is-white is-padded is-bordered-left">
        <h3 class="title is-3 is-size-5-mobile bold">What have you been working on lately?</h3>
        <p class="subtitle is-size-6-mobile">Share your recent work</p>
        <p>
            <a href="{{ route('new_portfolio') }}" class="button is-info big-action-button is-fullwidth-mobile">Upload your recent work</a>
        </p>
    </div> -->

    <!-- Portfolio section -->
    @if ( $portfolios )
        <div style="padding: 4em 0">
            <h2 class="title is-3 is-size-4-mobile has-text-black bold" style="margin-bottom: 10px;">Be inspired.</h2>
            <p>
                View recent works from the community. Like, Comment and Share.
            </p>
            <p style="margin-bottom: 3em;">
                <a href="{{ route('new_portfolio') }}" class="has-text-weight-bold button is-info is-raised">
                    <span class="icon"><i class="fa fa-upload"></i></span> <span>Upload work</span>
                </a>
            </p>
            <div class="columns is-multiline is-mobile">
                @each('includes.portfolio-with-user',  $portfolios, 'portfolio')
            </div>
        </div>
    @else
    @endif

    @if ( empty($user['skills']) )
        <div class="notification is-raised is-bordered-left is-padded is-white">
            <h3 class="title is-3 is-size-5-mobile bold">
                Setup your skills to see what other people like you are sharing
            </h3>
            <p>
                Get inspired by other peoples work and find people to follow.
            </p>
            <p><a href="{{ route('edit_profile') }}" class="button is-info big-action-button is-fullwidth-mobile">Add your skills</a></p>
        </div>
    @endif
    
    @if($suggestions)
    <div class="follow-suggestion is-white">
        <h2 class="title is-3 is-size-4-mobile has-text-black is-marginless bold">Who to follow</h2>
        <p>Make it more interesting by following others</p>
        <div class="user-to-follow-wrapper">
            <div class="scrollable-x">
                @for( $i = 0; $i < count($suggestions); $i++ )
                    <div class="user-to-follow has-text-centered">
                        <figure class="image is-rounded is-64x64 is-centered">
                            <img src="{{ $suggestions[$i]->avatar or '/public/default-user.jpg' }}" alt="{{ ucfirst($suggestions[$i]->first_name) }}">
                        </figure>
                        <h4 class="title is-7" style="margin-bottom: 0.7em"><a href="{{ route('view_profile', ['user'=>$suggestions[$i]->name]) }}">{{ ucfirst($suggestions[$i]->first_name) }}</a></h4>
                        <form action="/follower/{{$suggestions[$i]->name}}" method="post" class="follow-user-form">
                            <button type="submit" class="button is-small is-info">Follow</button>
                        </form>
                    </div>
                @endfor
            </div>
        </div>
    </div>
    @endif
    
    <!-- Blog section -->
    @if ( $blogs )
        <div style="padding: 4em 0">
            <h2 class="title is-3 is-size-4-mobile has-text-black bold" style="margin-bottom: 10px;">Find and read articles that inspire you to grow.</h2>
            <p>♥️ Connect with authors you love.</p>
            <p style="margin-bottom: 3em">
                <a href="{{ route('add_blog') }}" class="has-text-weight-bold button is-info is-raised">
                    <span class="icon"><i class="fa fa-pencil"></i></span> <span>Write new</span>
                </a>
            </p>         
            
            <div class="columns is-multiline is-mobile">
                @each('blog.partials.blog',  $blogs, 'blog')
            </div>
            <p>
                <a href="{{ route('add_blog') }}" class="button is-info big-action-button">Write something interesting</a>
            </p>
        </div>
    @else
    @endif

    @if($user['verified_email'] === 0)
        <div class="notification is-white is-raised is-bordered-left">
            <div class="is-size-6"><span class="icon"><i class="fa fa-envelope"></i></span> Please verify your email address <strong>{{Request::user()->email}}</strong>. <a href="{{route('verify')}}">Resend verification link</a></div>
        </div>
    @endif

    @if($gmail === true && $invite_status === false)
        @include('includes.gmail-invite')
    @endif

    @if(!$user['verified'])
        <div class="notification is-white is-raised is-bordered-left">
            <div class="is-size-6"><span class="icon verified"></span> Verify your identity and increase your ranking instantly and improve your credibility score <a href="{{ route('verify_identity') }}">Verify my identity</a></div>
        </div>
    @endif

    @if(Auth::user()->is_admin === 1)
    <div class="hero is-dark">
        <div class="hero-body has-text-centered">
            <h3 class="title is-4 is-size-6-mobile">Send contact invite reminder</h3>
            <send-reminder></send-reminder>
        </div>
    </div>
    @endif
    
@endsection
