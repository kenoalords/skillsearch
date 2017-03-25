@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Bio</h4></div>

                <div class="panel-body">

                    <form action="{{ route('personal_info') }}" method="POST">

                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                            <label for="bio">Tell us about yourself</label>
                            <p><small>This is what your potential clients and the public will see. A minimum of 200 characters is required</small></p>

                            <textarea name="bio" class="form-control" rows="10">{{ old('bio') ? old('bio') : $profile->bio }}</textarea>

                            @if ($errors->has('bio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bio') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div id="app">
                            <skills></skills>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Submit and continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
