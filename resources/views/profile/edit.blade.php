@extends('layouts.app')

@section('content')
<div class="container">
    <!-- @include('includes.profile-head') -->
    <div class="row padded">
        
        <div class="col-md-10 col-md-offset-1">
            @if(Request::session()->has('status'))
                <div class="alert alert-success">
                    <i class="glyphicon glyphicon-ok-sign"></i>
                    {{Request::session()->pull('status')}}
                    <a href="/home" class="pull-right">Go back</a>
                </div>
            @endif
            <div class="clearfix">
                <h3 class="pull-left" style="margin-top:0">Edit Profile</h3>
                <a href="/home" class="btn btn-basic pull-right"><i class="glyphicon glyphicon-home"></i> Back to profile</a>
            </div>
            <hr>
            <upload-image img-src="{{ $profile->getAvatar() }}"></upload-image>
            <div class="panel panel-default">

                <div class="panel-body">
                    <form action="/profile/edit" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                            <label for="bio" class="control-label">Bio</label>
                            <p><small>Tell us a little about yourself</small></p>
                            <div class="">
                                <textarea name="bio" class="form-control" rows="3" autofocus>{{ $profile->bio ? $profile->bio : old('bio') }}</textarea>
                                @if ($errors->has('bio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if (!$profile->gender)
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="control-label">Gender</label>
                            <div class="">
                                <select name="gender" class="form-control">
                                    <option value="">Select gender</option>
                                    <option value="male" {{ (old('gender') == 'male') ? 'selected' : ''   }}>Male</option>
                                    <option value="female" {{ (old('gender') == 'female') ? 'selected' : ''   }}>Female</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <div class="form-group {{ $errors->has('user_location') ? ' has-error' : '' }}">
                            <label for="location">Choose your primary location</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                <input type="text" name="user_location" id="geolocation" class="form-control" value="{{ (old('user_location')) ? old('user_location') :$profile->location}}">
                            </div>
                            @if ($errors->has('user_location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_location') }}</strong>
                                </span>
                            @endif
                        </div>

                        @if ( $profile->account_type == 1 )
                            
                            <skills></skills>

                        @endif

                        <button type="submit" class="btn btn-primary">Save Profile</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection