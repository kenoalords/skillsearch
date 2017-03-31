@extends('layouts.app')

@section('title', $profile->first_name . ' ' . $profile->last_name)
@section('metadescription', e(str_limit($profile->bio, 100)))
@section('thumbnail', $profile->getAvatar())
@section('type', 'article')

@section('content')

<div id="profile-back">
    <div class="user-background">
        <img src="{{ $profile->getUserBackground() }}" alt="{{ $profile->first_name }} {{ $profile->last_name }}">
    </div>
    <div class="container">
        <div class="col-md-6 col-md-offset-3 text-center">
            <div style="margin-bottom: 1em">
                <img src="{{ $profile->getAvatar() }}" width="150" height="150" class="img-circle avatar" style="margin-bottom: 0">
            </div>
            <div>
                <h1>{{ $profile->first_name }} {{ $profile->last_name }} {!! identity_check($profile->getVerified()) !!}</h1>
                <p><i class="glyphicon glyphicon-map-marker"></i> {{ $profile->location }}</p>
                <p class="skills-default">
                @foreach ($profile->skills as $skill)
                    <a href="/search?term={{ urlencode($skill->skill) }}" class="label label-xs label-default">{{ $skill->skill }}</a>
                @endforeach
                </p><br>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="clearfix row padded">
            <div class="col-md-3">
                <h4>Bio.</h4>
                <hr>
                <div>
                    {!! $profile->bio !!}
                    <br><br>
                    <follow username="{{$name}}"></follow>
                    <hr>
                </div>

                <!-- <p>{!! verifyStatus($profile) !!}</p> -->
                @if($profile->phones->count() && Auth::user())
                    <div class="padded">
                        <h4>Contact Number</h4>
                        @foreach($profile->phones as $phone)
                        <span><i class="glyphicon glyphicon-phone"></i> {{$phone->number}}</span>
                        @endforeach
                    </div>
                @endif
                @if(Auth::user() && Auth::user()->id !== $profile->user_id)
                <a href="{{ route('hire', ['user' => $name] )}}" class="btn btn-primary btn-block">Request {{$profile->first_name}}'s Service</a>
                @endif

                @if(!Auth::user())
                <a href="{{ route('hire', ['user' => $name] )}}" class="btn btn-primary btn-block">Request {{$profile->first_name}}'s Service</a>
                @endif
            </div>

            <div class="col-md-9">
                @if(count($portfolios))
                    <h4 class="bold">Portfolio</h4>
                    <hr>
                    <div class="row" id="showcase" style="padding: 0">
                        @each('includes.portfolio', $portfolios, 'portfolio')
                    </div>
                @endif
                @if(count($portfolios) == 0)
                    <h4 class="bold">Portfolio</h4>
                    <hr>
                    <p>{{ $profile->first_name }} has not uploaded any item to their portfolio, please check back again</p>
                @endif
                <!-- <h4 class="bold">About</h4>
                <hr>
                <p>{!! nl2br($profile->bio) !!}</p> -->
                <!-- <div class="clearfix">
                    <div class="padded">
                        <reviews username="{{ $name }}" user-id="{{ $profile->user_id }}"></reviews>
                    </div>
                </div> -->
            </div>
            
            
        </div>

        

        

    </div>
</div>
@endsection
