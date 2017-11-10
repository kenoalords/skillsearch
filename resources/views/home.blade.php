@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    @include('includes.status')
    
    @if(!$user['phone'])
        <div class="ui warning icon message">
            <i class="icon phone"></i>
            <div class="content">
                <div class="header">You have not added your contact number</div>
                <p>Add a phone number potential clients can reach you on quickly. </p>
                <a href="{{route('add_phone')}}" class="ui small icon labeled green button"><i class="icon plus"></i>Add contact number</a>
            </div>
        </div>
    @endif

    @if(!$user['has_instagram'])
        @include('includes.instagram')
    @endif
    
    @if($user['verified_email'] === 0)
        <div class="ui warning mini icon message">
            <i class="icon warning sign"></i>
            <div class="content">
                <div class="header">Please verify your email address <strong>{{Request::user()->email}}</strong>. <a href="{{route('verify')}}">Resend verification link</a></div>
            </div>
        </div>
    @endif

    @if($gmail === true && $invite_status === false)
        @include('includes.gmail-invite')
    @endif

    @if(!$user['verified'])
            <div class="ui warning icon mini message">
                <i class="icon warning sign"></i> 
                <div class="content">
                    <div class="header">Verify your identity and increase your ranking instantly and improve your credibility score <strong><a href="{{ route('verify_identity') }}">Verify my identity</a></strong>
                    </div>
                </div>
            </div>
    @endif

    {{-- @if($user['account_type'] === 1)
        <h3 class="ui header">Your Portfolio</h3>
        @if(count($user['portfolios']) > 0)
            <div class="ui container grid" style="margin-left: -1rem !important;">
                @foreach($user['portfolios'] as $portfolio)
                    @include('includes.portfolio-with-user', $portfolio)
                @endforeach
            </div>
        @endif
        <div style="margin: 1em 0"><a href="/profile/portfolio/add" class="ui basic grey icon labeled button"><i class="icon add"></i>Add portfolio item</a></div>
    @endif --}}

    @if($activities)
        <h3 class="ui header">
            Recent portfolio of people you follow
        </h3>
    	<div class="ui container grid" style="margin-left: -1rem !important;" id="user-portfolio-activity">
    		@each('includes.portfolio-with-user', $activities, 'portfolio')
    	</div>
        <div class="ui center aligned grid">
            <a href="#" class="ui button" id="load-more-activity" data-page="1" data-limit="16">Load more</a>
        </div>
    @endif

    @if(!$activities && $profiles !== null)
        <h3 class="ui header">
            Connect
            <div class="sub header">Connect and discover new works daily from amazing talents</div>
        </h3>
        <div class="ui divider"></div>
        <div class="">
            @each('profile.person-follow-tag', $profiles, 'profile');
        </div>
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
