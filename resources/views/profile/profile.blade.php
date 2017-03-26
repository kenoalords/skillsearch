@extends('layouts.app')

@section('title', $profile->first_name . ' ' . $profile->last_name . ' - ')

@section('content')

<div id="profile-back">
    <div class="user-background">
        <img src="{{ $profile->getUserBackground() }}" alt="{{ $profile->first_name }} {{ $profile->last_name }}">
    </div>
    <!-- <div class="container">
        <div class="clearfix">
            <div class="pull-left" style="margin-right: 1em">
                <img src="{{ $profile->getAvatar() }}" width="50" height="50" class="img-circle" style="margin-bottom: 0">
            </div>
            <div class="pull-left">
                <h1>{{ $profile->first_name }} {{ $profile->last_name }}</h1>
            </div>
            <div class="pull-right">
                <follow username="{{$name}}"></follow>
            </div>
        </div>
    </div> -->
</div>

<div class="container">
    <div class="row">
        <div class="clearfix row">
            <div class="col-md-3">
                <div class="text-center">
                    <img src="{{ $profile->getAvatar() }}" width="100" height="100" class="img-circle" style="margin-bottom: 0">
                    <h1 style="font-size: 1.4em" class="bold">{{ $profile->first_name }} {{ $profile->last_name }}</h1>
                    <p><i class="glyphicon glyphicon-map-marker"></i> {{ $profile->location }}</p>
                </div>
                
                <hr>
                <p class="skills-default">
                @foreach ($profile->skills as $skill)
                    <a href="/search?term={{ urlencode($skill->skill) }}" class="label label-xs label-default">{{ $skill->skill }}</a>
                @endforeach
                </p><br>
                <!-- <p>{!! verifyStatus($profile) !!}</p> -->
                @if($profile->phones->count() && Auth::user())
                    <div class="padded">
                        <h4>Contact Number</h4>
                        @foreach($profile->phones as $phone)
                        <span><i class="glyphicon glyphicon-phone"></i> {{$phone->number}}</span>
                        @endforeach
                    </div>
                @endif

                <a href="{{ route('hire', ['user' => $name] )}}" class="btn btn-primary btn-block">Request {{$profile->first_name}}'s Service</a>
            </div>

            <div class="col-md-9">
                @if(count($portfolios))
                    <br><br>
                    <h4 class="bold">{{ $profile->first_name }}'s Portfolio</h4>
                    <hr>
                    <div class="row" id="showcase" style="padding: 0">
                        @each('includes.portfolio', $portfolios, 'portfolio')
                    </div>
                @endif
                <!-- <h4 class="bold">About</h4>
                <hr>
                <p>{!! nl2br($profile->bio) !!}</p> -->
                <div class="clearfix">
                    <div class="padded">
                        <reviews username="{{ $name }}" user-id="{{ $profile->user_id }}"></reviews>
                    </div>
                </div>
            </div>
            
            
        </div>

        

        

    </div>
</div>
@endsection
