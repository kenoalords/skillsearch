@extends('layouts.user')

@section('title', 'Create Account')
@section('metadescription', 'Create a Free account and start promoting your works on ' .config('app.name'))
@section('thumbnail', config('app.thumbnail'))
@section('type', 'portfolio')

@section('content')

<h3 class="ui centered header">Create Account</h3>
<div>
    <a href="{{route('google')}}" class="ui icon labeled google plus fluid button"><i class="icon google"></i> Sign in with Google</a><br>
    <a href="{{route('facebook')}}" class="ui icon labeled facebook fluid button"><i class="icon facebook"></i> Sign in with Facebook</a>
</div>
<div class="ui divider"></div>
<form class="ui form" role="form" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="field{{ $errors->has('name') ? ' error' : '' }}">
        <div>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Username">
            <p><small>Only alphanumeric characters are allowed</small></p>
            @if ($errors->has('name'))
                <span class="ui pointing red basic label">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field{{ $errors->has('first_name') ? ' error' : '' }}">
        <div>
            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="First Name">
            @if ($errors->has('first_name'))
                <span class="ui pointing red basic label">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field{{ $errors->has('last_name') ? ' error' : '' }}">
        <div>
            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus placeholder="Last Name">
            @if ($errors->has('last_name'))
                <span class="ui pointing red basic label">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field{{ $errors->has('email') ? ' error' : '' }}">
        <div>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="E-Mail Address">

            @if ($errors->has('email'))
                <span class="ui pointing red basic label">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field{{ $errors->has('password') ? ' error' : '' }}">
        <div>
            <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

            @if ($errors->has('password'))
                <span class="ui pointing red basic label">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field">
        <div>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
        </div>
    </div>

    <!-- <div class="field {{ $errors->has('referral_code') ? ' error' : '' }}">
        <label for="">Referral Code (Optional)</label>
        <input type="text" name="referral_code">
        @if ($errors->has('referral_code'))
        <div class="ui pointing red basic label">
            Your referral code is invalid
        </div>
        @endif
    </div> -->

    <div class="field">
        <button type="submit" class="ui primary fluid button">Register</button>
    </div>
    <div class="field">
        <h4>Have an account? <a href="/login" class="bold">Log in</a></h4>
    </div>
</form>


@endsection
