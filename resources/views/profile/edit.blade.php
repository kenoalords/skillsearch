@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
    @if(Request::session()->has('status'))
        <div class="ui icon success message">
            <i class="icon check circle"></i>
            <div class="content">
                {{Request::session()->pull('status')}}
            </div>
        </div>
    @endif
    <div class="ui row">
        <h1 class="ui dividing header">Edit Profile</h1>
    </div>
    <div class="ui row">
        <upload-image img-src="{{ $profile->getAvatar() }}"></upload-image>
        <div class="ui divider"></div>
        <form action="/profile/edit" method="post" class="ui form" id="profile-edit-form">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            
            <div class="two fields">
                <div class="field">
                    <label for="firstname">First name</label>
                    <input type="text" name="first_name" id="firstname" value="{{ $profile->first_name ? $profile->first_name : old('first_name') }}">
                    @if ($errors->has('first_name'))
                        <span class="ui pointing red basic label">
                            {{ $errors->first('first_name') }}
                        </span>
                    @endif
                </div>
                <div class="field">
                    <label for="lastname">Last name</label>
                    <input type="text" name="last_name" id="lastname" value="{{ $profile->last_name ? $profile->last_name : old('last_name') }}">
                    @if ($errors->has('last_name'))
                        <span class="ui pointing red basic label">
                            {{ $errors->first('last_name') }}
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="field{{ $errors->has('bio') ? ' error' : '' }}">
                <h4 class="ui header">Tell us a little about yourself</h4>
                <textarea name="bio" rows="5" autofocus>{{ $profile->bio ? $profile->bio : old('bio') }}</textarea>
                @if ($errors->has('bio'))
                    <span class="ui pointing red basic label">
                        <strong>{{ $errors->first('bio') }}</strong>
                    </span>
                @endif
            </div>
            <div class="ui two fields">
                <div class="field{{ $errors->has('gender') ? ' error' : '' }}">
                    <h4 class="ui header">Gender</h4>
                    <div class="ui selection dropdown" id="gender">
                        <div class="default text">Select Gender</div>
                        <i class="dropdown icon"></i>
                        <input type="hidden" name="gender">
                        <div class="menu" data-default="{{$profile->gender}}">
                            <div class="item" data-value="male">Male</div>
                            <div class="item" data-value="female">Female</div>
                        </div>
                        @if ($errors->has('gender'))
                            <span class="ui pointing red basic label">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="field {{ $errors->has('user_location') ? ' error' : '' }}">
                    <h4 class="ui header">Enter your location <span class="ui grey">(City, State)</span></h4>
                    <div class="ui action input">
                        <input type="text" name="user_location" id="geolocation" value="{{ (old('user_location')) ? old('user_location') :$profile->location}}">
                        <!-- <button id="get-location" class="ui red labeled icon button">
                            <i class="marker icon"></i>
                            Get Location
                        </button> -->
                    </div>
                    @if ($errors->has('user_location'))
                        <span class="ui pointing red basic label">
                            <strong>{{ $errors->first('user_location') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if ( $profile->account_type == 1 )
                <div class="field">
                    <skills></skills>
                </div>
            @endif

            <button type="submit" class="ui primary large button">Save Profile</button>

        </form>
    </div>
@endsection