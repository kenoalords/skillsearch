@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <h3 class="text-center">Login</h3>

            <div class="panel panel-default boxed">
                
                <div class="panel-body">
                    
                    <form class="" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <div class="">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class=" control-label">Password</label>

                            <div class="">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Login
                            </button>
                            
                            <p class="text-center">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </p>
                        </div>
                    </form>
                    <hr>
                    <a href="{{route('google')}}" class="btn btn-block btn-danger">Sign in with Google</a>
                    <br>
                    <a href="{{route('facebook')}}" class="btn btn-block btn-primary">Sign in with Facebook</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
