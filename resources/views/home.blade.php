@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div style="margin-bottom: 1em">
        <h4 style="color: #e74c3c" class="title is-4">You have earned {{number_format($user['points'])}} points.</h4>
        <div class="subtitle is-6">Want to earn more points? <a href="/points">Find out how.</a></div>
    </div>
    @include('includes.status')
    
    @if(!$user['phone'])
        <div class="notification ">
            <div class="header">You have not added your contact number</div>
            <a href="{{route('add_phone')}}" class="button is-primary">Add phone number</a>
        </div>
    @endif

    @if(!$user['has_instagram'])
        @include('includes.instagram')
    @endif
    
    @if($user['verified_email'] === 0)
        <div class="notification is-danger">
            <div class="title is-6"><span class="icon"><i class="fa fa-envelope"></i></span> Please verify your email address <strong>{{Request::user()->email}}</strong>. <a href="{{route('verify')}}">Resend verification link</a></div>
        </div>
    @endif

    

    @if(!$user['verified'])
        <div class="notification is-info">
            <div class="title is-6"><span class="icon verified"></span> Verify your identity and increase your ranking instantly and improve your credibility score <a href="{{ route('verify_identity') }}">Verify my identity</a></div>
        </div>
    @endif

    

    @if($activities)
        <h3 class="title is-4">
            Recent portfolio of people you follow
        </h3>
    	<div class="columns is-multiline">
    		@each('includes.portfolio-with-user', $activities, 'portfolio')
    	</div>
        <div>
            <a href="#" class="button is-info is-small" id="load-more-activity" data-page="1" data-limit="16"><span class="icon"><i class="fa fa-th"></i></span> <span>Load more</span></a>
        </div>
    @endif

    

    @if(!$activities && $profiles !== null)
        <div class="hero is-primary">
            <div class="hero-body">
                <h3 class="title is-4">Connect</h3>
                <div class="subtitle is-6">Connect and discover new works daily from amazing talents</div>
                <div class="columns is-multiline">
                    @each('profile.person-follow-tag', $profiles, 'profile');
                </div>
            </div>
        </div>
    @endif

    @if($gmail === true && $invite_status === false)
        @include('includes.gmail-invite')
    @endif

    {{-- @if ( count($tasks) > 0 )
        <h3 class="ui dividing header" style="margin-top: 3em">
            Recent Jobs
            <!-- <div class="sub header"></div> -->
        </h3>
        <div class="ui divided very relaxed list">
            @each('task.partials.task', $tasks, 'task')
        </div>
    @endif --}}
    
@endsection
