@extends('layouts.user')
@section('title', 'Setup your account')
@section('content')

<h1 class="ui medium header">Setup your profile</h1>
<div class="ui divider"></div>

<form action="{{ route('start') }}" method="POST" class="ui form">
    {{ csrf_field() }}
    <div class="field{{ $errors->has('username') ? ' error' : '' }}">
        <div class="ui icon input">
            <i class="icon user"></i>
            <input type="text" name="username" value="{{ old('username') ? old('username') : $name  }}" placeholder="username">
        </div>
        <p>Change your username</p>
        @if ($errors->has('username'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
    </div>
    <div class="field{{ $errors->has('first_name') ? ' error' : '' }}">
        <input type="text" name="first_name" value="{{old('first_name')}}" placeholder="First Name">
        @if ($errors->has('first_name'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('first_name') }}</strong>
            </span>
        @endif
    </div>

    <div class="field{{ $errors->has('last_name') ? ' error' : '' }}">
        <input type="text" name="last_name" value="{{old('last_name')}}" placeholder="Last Name">

        @if ($errors->has('last_name'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
    </div>
    
    <div class="field {{ $errors->has('gender') ? ' error' : '' }}">
        <label>Gender</label>
        <div class="ui selection dropdown">
            <input type="hidden" name="gender">
            <i class="dropdown icon"></i>
        <div class="default text">Gender</div>
            <div class="menu">
              <div class="item" data-value="male">Male</div>
              <div class="item" data-value="female">Female</div>
            </div>
        </div>
       
        @if ($errors->has('gender'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('gender') }}</strong>
            </span>
        @endif
    </div>
    
    <div class="field {{ $errors->has('location') ? ' error' : '' }}">
        <label for="">Location</label>
        <div class="ui icon input">
            <i class="icon marker"></i>
            <input type="text" id="geolocation" name="location" value="{{old('location')}}" placeholder="City, State">
        </div>
        @if ($errors->has('location'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('location') }}</strong>
            </span>
        @endif
    </div>

    <div class="field {{ $errors->has('bio') ? ' error' : '' }}">
        <label for="">Bio</label>
        <textarea name="bio" rows="3" placeholder="Tell us a little bit about yourself">{{old('bio')}}</textarea>
        @if ($errors->has('bio'))
            <span class="ui pointing red basic label">
                <strong>{{ $errors->first('bio') }}</strong>
            </span>
        @endif
    </div>
    
    <h3 class="ui header">I will like to</h3>
    <div class="ui divider"></div>

    <div class="ui fields">
        <div class="field">
            <label>
                <input type="radio" name="account_type" value="1" {{old('account_type') == '1' ? 'checked' : ''}}> Promote my work
            </label>
        </div>
        <div class="field">
            <label>
                <input type="radio" name="account_type" value="0" {{old('account_type') == '0' ? 'checked' : ''}}> Hire a skilled person
            </label>
        </div>
    </div>

    @if ($errors->has('account_type'))
        <span class="ui pointing red basic label">
            <strong>{{ $errors->first('account_type') }}</strong>
        </span>
    @endif

    <div class="field">
        <button type="submit" class="ui primary fluid button">Save and continue</button>
    </div>
</form>

@endsection
