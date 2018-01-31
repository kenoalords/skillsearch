@extends('layouts.account')

@section('title', 'Create Account')
@section('metadescription', 'Create a Free account and start promoting your works on ' .config('app.name'))
@section('thumbnail', config('app.thumbnail'))
@section('type', 'portfolio')

@section('content')

<div class="hero is-white">
    <div class="hero-body">
        
        <div>
            <div class="field">
                <h4><a href="{{route('google')}}" class="button is-danger is-block">Continue with Google</a></h4>
            </div>
            <div class="field">
                <h4><a href="{{route('facebook')}}" class="button is-link is-block">Continue with Facebook</a></h4>
            </div>
        </div>
        <h3 class="title is-5 has-text-centered" style="margin-top: 1em">Create Account</h3>
        <form class="ui form" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="field">
                <div class="control">
                    <input id="name" type="text" class="{{ $errors->has('name') ? ' is-danger' : '' }} input" name="name" value="{{ old('name') }}" required autofocus placeholder="Username">
                    <p class="help">Only alphanumeric characters are allowed</p>
                    @if ($errors->has('name'))
                        <span class="help is-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input id="first_name" type="text" class="input {{ $errors->has('first_name') ? ' is-danger' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="First Name">
                    @if ($errors->has('first_name'))
                        <span class="help is-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input id="last_name" type="text" class="input {{ $errors->has('last_name') ? ' is-danger' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus placeholder="Last Name">
                    @if ($errors->has('last_name'))
                        <span class="help is-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required placeholder="E-Mail Address">

                    @if ($errors->has('email'))
                        <span class="help is-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="help is-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input id="password-confirm" type="password" class="input" name="password_confirmation" required placeholder="Confirm Password">
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
                <button type="submit" class="button is-primary is-block">Register</button>
            </div>
            <div class="field">
                <p>Have an account? <a href="/login" class="has-text-link">Log in</a></p>
            </div>
        </form>
    </div>
</div>



@endsection
