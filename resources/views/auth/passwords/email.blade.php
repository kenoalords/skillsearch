@extends('layouts.user')

@section('content')

@if (session('status'))
    <div class="ui info message">
        {{ session('status') }}
    </div>
@endif

<form class="ui form" role="form" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}

    <div class="field{{ $errors->has('email') ? ' error' : '' }}">
        <label>Enter your email address to reset your password</label>
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Enter your email address">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="field">
        <button type="submit" class="ui primary fluid button">
            Reset Password
        </button>
    </div>
</form>

@endsection
