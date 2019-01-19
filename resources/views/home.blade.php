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
    <!-- @if($user['verified_email'] === 0)
        <div class="notification is-danger">
            <div class="title is-6"><span class="icon"><i class="fa fa-envelope"></i></span> Please verify your email address <strong>{{Request::user()->email}}</strong>. <a href="{{route('verify')}}">Resend verification link</a></div>
        </div>
    @endif -->

    @if(!$user['verified'])
        <div class="notification">
            <div class="title is-6"><span class="icon verified"></span> Verify your identity and increase your ranking instantly and improve your credibility score <a href="{{ route('verify_identity') }}">Verify my identity</a></div>
        </div>
    @endif

    @if($gmail === true && $invite_status === false)
        @include('includes.gmail-invite')
    @endif

    @if(Auth::user()->is_admin === 1)
    <div class="hero is-dark">
        <div class="hero-body has-text-centered">
            <h3 class="title is-4">Send contact invite reminder</h3>
            <send-reminder></send-reminder>
        </div>
    </div>
    @endif
    
@endsection
