@extends('layouts.account')
@section('title', 'Verify Account')
@section('content')

<div class="hero">
    <div class="hero-body">
        @if(!Session::get('status'))
        <div>
             <h3 class="ui header">Hi {{$profile->first_name}},</h3>
             <p>You are yet to verify your email address <strong>{{$profile->user->email}}</strong>.</p>
             <p><a href="{{route('resend_verify')}}" class="button is-primary is-block">Resend verification email</a></p>
        </div>
        @endif

        @if(Session::get('status'))
            @include('includes.status')
            <p>
                <a href="/dashboard" class="button is-primary is-block">
                    <i class="fa fa-arrow-left"></i>
                    Go back to profile
                </a>
            </p>
        @endif
    </div>
</div>
@endsection
