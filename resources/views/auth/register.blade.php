@extends('layouts.app')

@section('title', 'Create Account')
@section('metadescription', 'Create a Free account and start promoting your works on Skillsearch Nigeria')
@section('thumbnail', config('app.thumbnail'))
@section('type', 'portfolio')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <h3 class="text-center">Create Account</h3>
            <div class="panel panel-default boxed">
                <div class="panel-body">
                    <a href="{{route('google')}}" class="btn btn-block btn-danger">Sign in with Google</a>
                    
                    <a href="{{route('facebook')}}" class="btn btn-block btn-primary">Sign in with Facebook</a>
                    <hr>
                    <form class="" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Username">
                                <p><small>Only alphanumeric characters are allowed</small></p>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <div>
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="First Name">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <div>
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus placeholder="Last Name">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="E-Mail Address">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div>
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('account_type') ? ' has-error' : '' }}">
                            <h4 class="text-center">I Want To</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="btn btn-default btn-block">
                                        <input type="radio" name="account_type" value="1"> Find Work
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="btn btn-default btn-block">
                                        <input type="radio" name="account_type" value="0"> Hire Someone
                                    </label>
                                </div>
                            </div>
                            @if ($errors->has('account_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('account_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
