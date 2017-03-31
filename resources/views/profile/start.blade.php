@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row padded">
        <div class="col-md-8 col-md-offset-2">
            <h2 class="text-center">Setup your profile</h2>
            <hr>

            <form action="{{ route('start') }}" method="POST">
                <div class="panel panel-default boxed">
                    <div class="panel-body">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon">{{ config('app.url') }}/</span>
                                <input type="text" name="username" class="form-control" value="{{ old('username') ? old('username') : $name  }}">
                            </div>
                            <small>Change your username</small>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" placeholder="First Name">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" placeholder="Last Name">

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                            <select name="gender" id="gender" class="form-control">
                                <option value="0">Gender</option>
                                <option value="male" {{old('gender') == 'male' ? 'selected' : ''}}>Male</option>
                                <option value="female" {{old('gender') == 'female' ? 'selected' : ''}}>Female</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                                <input type="text" id="geolocation" name="location" class="form-control" value="{{old('location')}}">
                            </div>
                            @if ($errors->has('location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('bio') ? ' has-error' : '' }}">
                            <textarea name="bio" class="form-control" rows="3" placeholder="Tell us a little bit about yourself, please keep it short">{{old('bio')}}</textarea>
                            @if ($errors->has('bio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bio') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <h3 class="text-center">I will like to</h3>
                <hr>

                <div class="panel panel-default boxed">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="account_type" value="1" {{old('account_type') == '1' ? 'checked' : ''}}> Promote my skills
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="btn btn-default btn-block">
                                    <input type="radio" name="account_type" value="0" {{old('account_type') == '0' ? 'checked' : ''}}> Hire a skilled person
                                </label>
                            </div>
                        </div>

                        @if ($errors->has('account_type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('account_type') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Save and continue</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
