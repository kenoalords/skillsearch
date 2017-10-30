@extends('layouts.app')

@section('title', 'Contact ' . $profile['fullname'])

@section('content')

<div class="ui container">            
    <div class="ui two column centered grid">
        @if(Auth::user() && Auth::user()->id !== $profile['user_id'])
            <request-service first-name="{{ $profile['first_name'] }}"  username="{{$profile['username']}}" skills="{{json_encode($profile['skills'])}}" avatar="{{$profile['avatar']}}"></request-service>
        @endif

        @if(Auth::user() && Auth::user()->id === $profile['user_id'])
            <div class="padded text-center">
                <h2 class="thin">Sorry {{ $profile['fullname'] }}!</h2>
                <hr>

                <p>You cannot request your own services</p>
                <p><a href="/home">Go to your profile</a></p>
            </div>
        @endif

        @if(!Auth::user())
            <div class="padded text-center">
                <h2 class="ui header">Contact {{ $profile['fullname'] }}</h2>
                <p>You need to be logged in to hire or request any of {{ $profile['first_name'] }} services. It only takes a few seconds.</p>
                <p><a href="/login" class="ui primary button">Sign in to request service</a></p>
            </div>
        @endif
    </div>
</div>
@endsection
