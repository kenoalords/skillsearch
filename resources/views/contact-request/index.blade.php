@extends('layouts.user')

@section('title', 'Contact Request')

@section('content')

@if($profile['phone'])

<form action="{{ route('contact_request_post', ['user'=>$profile['username']]) }}" method="post" class="ui form">
    {{ csrf_field() }}
    <div class="field">
        <span>
            <a href="/{{ $profile['username'] }}" class="bold">
                <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="ui avatar image">
                {{ $profile['fullname'] }}
            </a>
        </span>
        <h1 class="ui medium header">Request {{ $profile['first_name'] }}'s Contact</h1>
    </div>
    <div class="ui divider"></div>
    <div class="field {{ $errors->has('fullname') ? ' error' : '' }}">
        <input type="text" name="fullname" placeholder="Your fullname" value="{{ Request::old('fullname') }}">
        @if ($errors->has('fullname'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('fullname') }}</strong>
            </span>
        @endif
    </div>
    <div class="field {{ $errors->has('email') ? ' error' : '' }}">
        <input type="email" name="email" placeholder="Your email address" value="{{ Request::old('email') }}">
        @if ($errors->has('email'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="field {{ $errors->has('location') ? ' error' : '' }}">
        <input type="text" name="location" placeholder="Your location (City, State)" value="{{ Request::old('location') }}">
        @if ($errors->has('location'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('location') }}</strong>
            </span>
        @endif
    </div>
    <div class="field {{ $errors->has('phone') ? ' error' : '' }}">
        <input type="text" name="phone" placeholder="Your phone number (Optional)" value="{{ Request::old('phone') }}">
    </div>
    <div class="field">
        <button type="submit" class="ui fluid green button">Request Contact</button>
    </div>
</form>

@else 

<span>
    <a href="/{{ $profile['username'] }}" class="bold">
        <img src="{{ $profile['avatar'] }}" alt="{{ $profile['fullname'] }}" class="ui avatar image">
        {{ $profile['fullname'] }}
    </a>
</span>

<h3 class="ui medium header">{{ $profile['fullname'] }} is yet to setup their contact details. Please check back later</h3>

<a href="{{url()->previous()}}" class="ui fluid icon button"><i class="icon arrow left"></i>Back</a>

@endif

@endsection
