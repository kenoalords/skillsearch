@extends('layouts.account')
@section('title', 'Recover password')
@section('content')
<div class="hero is-white">
    <div class="hero-body">
        @if (session('status'))
            <div class="notification is-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="ui form" role="form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <p>Enter your registered email address to reset your password</p>
            <div class="field">
                <div class="control has-icons-left">
                    <input type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Enter your email address">
                    <span class="icon is-small is-left">
                        <i class="fa fa-envelope"></i>
                    </span>
                    @if ($errors->has('email'))
                        <span class="help is-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                
            </div>

            <div class="field">
                <button type="submit" class="button is-block is-info">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
