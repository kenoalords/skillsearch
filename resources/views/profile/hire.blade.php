@extends('layouts.app')

@section('title', $profile->first_name . ' ' . $profile->last_name . ' - ')

@section('content')

<div class="container">            
    <div class="col-md-8 col-md-offset-2">
        @if(Auth::user() && Auth::user()->id !== Request::user()->id)
            <request-service first-name="{{ $profile->first_name }}"  username="{{$name}}" skills="{{$profile->skills}}"></request-service>
        @endif

        @if(Auth::user() && Auth::user()->id === Request::user()->id)
            <div class="padded text-center">
                <h2 class="thin">Sorry {{ $profile->first_name }}!</h2>
                <hr>

                <p>You cannot request your own services</p>
                <p><a href="/home">Go to your profile</a></p>
            </div>
        @endif

        @if(!Auth::user())
            <div class="padded text-center">
                <h2 class="thin">Hire {{ $profile->first_name }}</h2>
                <hr>

                <p>You need to be logged in to hire or request any of {{ $profile->first_name }} services. It only takes a few seconds.</p>
                <p><a href="/login" class="btn btn-primary">Sign in to request service</a></p>
            </div>
        @endif
        <!-- <a href="{{ route('send_message', ['user' => $name]) }}" class="btn btn-default btn-block">Request Service</a> -->
    </div>
</div>
@endsection
