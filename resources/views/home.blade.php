@extends('layouts.app')

@section('content')

<div class="row">

    @include('includes.profile-head')
    <div class="container padded">
        <div class="col-md-3 col-sm-4">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9 col-sm-8">
            @include('includes.status')

            @if($profile->user->instagram()->count() == 0)
            <div id="instagram-notification">
                <div class="white-boxed text-center">
                    <p><img src="{{ asset('public/instagram-teaser.jpg') }}" alt="Instagram"></p>
                    <p>Connect your instagram account and showcase more of your work</p>
                    <p>
                        <a href="/profile/portfolio/instagram" class="btn btn-success"><i class="fa fa-instagram"></i> Get Started</a>
                        <a href="#" class="btn btn-basic text-muted" id="close-instagram-notification"><i class="fa fa-close"></i> Close</a>
                    </p>
                </div>
                <hr>
            </div>
            @endif
            
            @if($profile->verified_email === 0)
                <div class="alert alert-danger dismissable">
                    <p>
                        Your email address <strong>{{$profile->user->email}}</strong> has not been verified, please check your inbox and click on the verification link. <a href="{{route('verify')}}">Resend verification link</a>
                    </p>
                </div>
                <hr>
            @endif

            @if($gmail === true && $invite_status === false)
                <div class="white-boxed text-center clearfix" style="padding: 2em;">
                    <p><img src="{{asset('public/gmail.png')}}" alt="Invite friends from Gmail" style="width: 120px; height: auto"></p>
                    <p>Find and connect with your friends already using {{config('app.name')}} to find new client</p>
                    <a href="/invite/gmail" class="btn btn-success" id="google-invite"><i class="fa fa-envelope"></i> Find Friends and Connect</a>
                </div>
                <hr>
            @endif

            @if(!$profile->identity)
                    <p class="text-info"><i class="glyphicon glyphicon-info-sign"></i> Verify your identity and increase your ranking instantly and improve your credibility score <strong><a href="{{ route('verify_identity') }}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-info-sign"></i> Verify my identity</a></strong></p>
            @endif
            @if($profile->identity && $profile->identity->status === 0)
                    <p class="alert alert-info"><i class="glyphicon glyphicon-info-sign"></i> We are processing your identity verification request. You will be notified via email once it has been verified</p>
            @endif
            <!-- <h4><i class="glyphicon glyphicon-graph"></i> Feed</h4> -->
            @if($activities)
        	<div id="activities">
        		@each('includes.activity', $activities, 'activity')
        	</div>
            @endif

            @if(!$activities)
            <div id="activities" class="padded text-center">
                <p style="font-size: 3em"><i class="glyphicon glyphicon-thumbs-down"></i></p>
                <p>Your activity log in empty</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
