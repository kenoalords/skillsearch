@extends('layouts.user')

@section('title', 'Login')
@section('metadescription', 'Login or signup to join hundreds of people using '.config('app.name').' to promote their works')
@section('thumbnail', config('app.thumbnail'))
@section('type', 'portfolio')

@section('content')
<div class="container">
    <form class="ui form" role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('email') ? ' error' : '' }}">
            <div class="ui left icon input">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="E-Mail Address">
                <i class="icon mail"></i>
            </div>
            @if ($errors->has('email'))
                <span class="ui pointing red basic label">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="field{{ $errors->has('password') ? ' error' : '' }}">
            <div class="ui left icon input">
                <input id="password" type="password" name="password" required placeholder="Password">
                <i class="icon key"></i>
            </div>
            @if ($errors->has('password'))
                <span class="ui pointing red basic label">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label> Remember Me</label>
            </div>
        </div>

        <div class="field">
            <button type="submit" class="ui primary fluid button">
                Login
            </button>
        </div>
        <h4><a href="{{ route('password.request') }}">Forgot Your Password?</a></h4>
        <div class="ui divider"></div>
        <div class="field">
            <a href="{{route('google')}}" class="ui icon google plus labeled fluid button"><i class="icon google"></i> Sign in with Google</a>
        </div>
        <div class="field">
            <a href="{{route('facebook')}}" class="ui icon facebook labeled fluid button"><i class="icon facebook"></i> Sign in with Facebook</a>
        </div>
        <div class="field">
            <h4>Don't have an account? <a href="/register" class="bold">Sign up</a></h4>
        </div>
    </form>
</div>
@endsection
