@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
    @include('includes.status')
    <h1 class="title is-2 bold">Edit Profile</h1>

    <div id="profile-image-wrapper" style="background: url({{ $profile->getUserBackground()  }}) no-repeat center; background-size: cover; margin-bottom: 3em;">
        <div class="hero is-medium">
            <div class="hero-body">
                <upload-image img-src="{{ $profile->getAvatar() }}"></upload-image>
            </div>
        </div>
        <user-background></user-background>
    </div>

    <div class="ui row">
        
        <form action="/dashboard/profile/edit" method="post" id="profile-edit-form">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            
            <div class="field is-grouped">
                <div class="control">
                    <label for="firstname" class="label">First name</label>
                    <input type="text" name="first_name" id="firstname" value="{{ $profile->first_name ? $profile->first_name : old('first_name') }}" class="input {{ ($errors->has('first_name')) ? 'is-danger' : '' }}">
                    @if ($errors->has('first_name'))
                        <span class="help is-danger">
                            {{ $errors->first('first_name') }}
                        </span>
                    @endif
                </div>
                <div class="control">
                    <label for="lastname" class="label">Last name</label>
                    <input type="text" name="last_name" id="lastname" value="{{ $profile->last_name ? $profile->last_name : old('last_name') }}" class="input {{ ($errors->has('last_name')) ? 'is-danger' : '' }}">
                    @if ($errors->has('last_name'))
                        <span class="help is-danger">
                            {{ $errors->first('last_name') }}
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="field">
                <label class="label" for="bio">Tell us a little about yourself</label>
                <textarea name="bio" id="bio" rows="2" autofocus class="textarea {{ $errors->has('bio') ? ' is-danger' : '' }}" placeholder="e.g I'm a professional makeup artist based in Lagos, Nigeria.">{{ $profile->bio ? $profile->bio : old('bio') }}</textarea>
                @if ($errors->has('bio'))
                    <span class="help is-danger">
                        <strong>{{ $errors->first('bio') }}</strong>
                    </span>
                @endif
            </div>
            <div class="field is-grouped">

                <div class="control">
                    <label for="gender" class="label">Gender</label>
                    <div class="select">
                        <select name="gender" class="{{ $errors->has('gender') ? ' is-danger' : '' }}">
                            <option value="0">Select</option>
                            <option value="male" {{($profile->gender && $profile->gender == 'male') ? 'selected' : ''}}>Male</option>
                            <option value="female" {{($profile->gender && $profile->gender == 'female') ? 'selected' : ''}}>Female</option>
                        </select>
                    </div>
                    @if ($errors->has('gender'))
                        <span class="help is-danger">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="control">
                    <label class="label">Enter your location <small>(City, State)</small></label>
                    <input type="text" name="user_location" id="geolocation" value="{{ (old('user_location')) ? old('user_location') :$profile->location}}" class="input {{ $errors->has('user_location') ? ' is-danger' : '' }}" placeholder="Ikeja, Lagos">
                    @if ($errors->has('user_location'))
                        <span class="help is-danger">
                            {{ $errors->first('user_location') }}
                        </span>
                    @endif
                    <span class="help is-danger">Please don't enter your full address, only your city and state.</span>
                </div>
            </div>

            <div class="hero">
                <div class="hero-body card is-raised">
                    <skills></skills>
                </div>              
            </div>
            
            <div style="margin-top: 2em;">
                <button type="submit" class="button is-info big-action-button">Save Profile</button>
            </div>
        </form>
    </div>
@endsection