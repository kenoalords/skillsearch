@extends('layouts.user')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form role="form" method="POST" action="{{ route('password.request') }}" class="ui form">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="field{{ $errors->has('email') ? ' error' : '' }}">
        <div>
            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="Email address">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field{{ $errors->has('password') ? ' error' : '' }}">
        <div>
            <input id="password" type="password" class="form-control" name="password" required placeholder="New password">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field{{ $errors->has('password_confirmation') ? ' error' : '' }}">
        <div>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm new password">

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="field">
            <button type="submit" class="btn btn-primary btn-block">
                Reset Password
            </button>
        </div>
    </div>
</form>

@endsection
