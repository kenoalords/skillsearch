@extends('layouts.account')
@section('title', 'Setup your account')
@section('content')

<div class="hero">
    <div class="hero-body">
        <h1 class="title is-6">Setup your profile</h1>

        <form action="{{ route('start') }}" method="POST">
            {{ csrf_field() }}
            <div class="field">
                <div class="control has-icons-left">
                    <input type="text" name="username" value="{{ old('username') ? old('username') : $name  }}" placeholder="username" class="{{ $errors->has('username') ? ' is-danger' : '' }} input">
                    <span class="icon is-small is-left">
                        <i class="fa fa-user"></i>
                    </span>
                </div>
                <p class="help">Change your username</p>
                @if ($errors->has('username'))
                    <span class="help is-danger">{{ $errors->first('username') }}</span>
                @endif
            </div>
            <div class="field">
                <div class="control">
                    <input type="text" name="first_name" value="{{old('first_name')}}" placeholder="First Name" class="input {{ $errors->has('first_name') ? ' is-danger' : '' }}">
                    @if ($errors->has('first_name'))
                        <span class="help is-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <input type="text" name="last_name" value="{{old('last_name')}}" placeholder="Last Name" class="input {{ $errors->has('last_name') ? ' is-danger' : '' }}">
                @if ($errors->has('last_name'))
                    <span class="ui pointing red basic label">{{ $errors->first('last_name') }}</span>
                @endif
            </div>

            <div class="field">
                <label for="phone" class="label">Phone number</label>
                <input type="text" name="phone" value="{{old('phone')}}" placeholder="e.g 08012345678" class="input {{ $errors->has('phone') ? ' is-danger' : '' }}" id="phone">
                <p class="help">This will enable clients contact you directly</p>
                @if ($errors->has('phone'))
                    <span class="ui pointing red basic label">{{ $errors->first('phone') }}</span>
                @endif
            </div>
            
            <div class="field ">
                <label class="label">Gender</label>

                <div class="select is-block">
                    <select name="gender" id="gender" style="width: 100%" class="{{ $errors->has('gender') ? ' is-danger' : '' }}">
                        <option value="0">Select</option>
                        <option value="male" {{ (old('gender') == 'male') ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ (old('gender') == 'female') ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                @if ($errors->has('gender'))
                    <span class="help is-danger">{{ $errors->first('gender') }}</span>
                @endif
            </div>
            
            <div class="field">
                <label for="" class="label">Location</label>
                <div class="control has-icons-left">
                    <input type="text" id="geolocation" name="location" value="{{old('location')}}" placeholder="City, State" class="input {{ $errors->has('location') ? ' is-danger' : '' }}">
                    <span class="icon is-small is-left">
                        <i class="fa fa-map-marker"></i>
                    </span>
                </div>
                @if ($errors->has('location'))
                    <span class="help is-danger">{{ $errors->first('location') }}</span>
                @endif
            </div>

            <div class="field">
                <label for="" class="label">Short Bio</label>
                <textarea name="bio" rows="3" placeholder="Tell us a little bit about yourself" class="textarea {{ $errors->has('bio') ? ' is-danger' : '' }}">{{old('bio')}}</textarea>
                @if ($errors->has('bio'))
                    <span class="help is-danger">{{ $errors->first('bio') }}</span>
                @endif
            </div>

            <div class="field">
                <button type="submit" class="button is-primary is-block">Save and continue</button>
            </div>
        </form>
    </div>
</div>


@endsection
