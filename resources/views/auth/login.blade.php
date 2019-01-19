@extends('layouts.account')

@section('title', 'Login')
@section('metadescription', 'Login or signup to join hundreds of people using '.config('app.name').' to promote their works')
@section('thumbnail', config('app.thumbnail'))
@section('type', 'portfolio')

@section('content')
<div class="hero">
    <div class="hero-body">
        <form role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="field">
                <div class="control has-icons-left">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="E-Mail Address" class="{{ $errors->has('email') ? ' is-danger' : '' }} input">
                    <span class="icon is-small is-left">
                        <i class="fa fa-envelope"></i>
                    </span>
                    @if ($errors->has('email'))
                        <span class="help is-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>      
            </div>

            <div class="field">
                <div class="control has-icons-left">
                    <input id="password" type="password" name="password" required placeholder="Password" class="{{ $errors->has('password') ? ' is-danger' : '' }} input">
                    <i class="icon key"></i>
                    <span class="icon is-small is-left">
                        <i class="fa fa-key"></i>
                    </span>
                    @if ($errors->has('password'))
                        <span class="help is-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>            
            </div>

            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="is-toggle">
                    <label> Remember Me</label>
                </div>
            </div>

            <div class="field">
                <button type="submit" class="button is-info is-block">
                    Login
                </button>
            </div>
            <p><a href="{{ route('password.request') }}" class="has-text-link">Forgot Your Password?</a></p>
            
            <div class="field">
                <h4><a href="{{route('google')}}" class="button is-danger is-block">Continue with Google</a></h4>
            </div>
           <!--  <div class="field">
                <h4><a href="{{route('facebook')}}" class="button is-link is-block">Continue with Facebook</a></h4>
            </div> -->

            <div class="field">
                <p>Don't have an account? <a href="/register" class="has-text-link">Sign up</a></p>
            </div>
        </form>
    </div>
</div>

@endsection
