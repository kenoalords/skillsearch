@extends('layouts.user')

@section('content')

@if(Request::session()->has('status'))
    <div>  
        <div class="ui info icon message">
            <i class="icon info"></i>
            {{Request::session()->pull('status')}}
        </div>
    </div>
@endif

<h3 class="ui header">Hi {{$request['name']}}</h3>
<div class="ui divider"></div>
<p>We noticed you already have an account setup with <strong>{{$request['email']}}</strong> on {{config('app.name')}}.</p>
<p>If you will like to have access to the same account with your <strong>{{ucfirst($request['provider'])}}</strong> login, please enter your password below to confirm or <a href="/login">click here to login</a></p>
<hr>
<form method="post" action="{{Request::fullUrl()}}" class="ui form">
    {{csrf_field()}}
    <div class="field {{ $errors->has('password') ? ' error' : '' }}">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span> 
            <input type="password" name="password" class="form-control" placeholder="Enter your password">
            <input type="hidden" name="user" value="{{$request['user']}}">
            <input type="hidden" name="email" value="{{$request['email']}}">
            <input type="hidden" name="provider" value="{{$request['provider']}}">
            <input type="hidden" name="social_id" value="{{$request['social_id']}}">
        </div>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>  
    <button class="ui fluid primary button">Submit</button>
</form>

@endsection
