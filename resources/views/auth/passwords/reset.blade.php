@extends('layouts.account')
@section('title', 'Reset password')
@section('content')

<div class="hero">
    <div class="hero-body">
        @if (session('status'))
            <div class="notification is-success">
                {{ session('status') }}
            </div>
        @endif

        <form role="form" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="field">
                <div class="control">
                    <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="Email address">

                    @if ($errors->has('email'))
                        <span class="help is-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required placeholder="New password">

                    @if ($errors->has('password'))
                        <span class="help is-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input id="password-confirm" type="password" class="input {{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" name="password_confirmation" required placeholder="Confirm new password">

                    @if ($errors->has('password_confirmation'))
                        <span class="help is-danger">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                    <button type="submit" class="button is-block is-primary">
                        Reset Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



@endsection
