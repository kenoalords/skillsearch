@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-md-8 col-md-offset-2">
            @if(!Session::get('status'))
            <div class="white-boxed text-center">
                 <h3>Hi {{$profile->first_name}},</h3>
                 <p>You are yet to verify your email address <strong>{{$profile->user->email}}</strong>.</p>
                 <p><a href="{{route('resend_verify')}}" class="btn btn-success">Resend verification email</a></p>
            </div>
            @endif

            @if(Session::get('status'))
                @include('includes.status')
                <p>
                    <a href="/home" class="btn btn-basic">
                        <i class="fa fa-arrow-left"></i>
                        Go back to profile
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
