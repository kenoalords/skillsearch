@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row padded">
    	@if(Request::session()->has('status'))
    		<div class="col-md-4 col-md-offset-4">	
			    <div class="alert alert-danger row">
			        <i class="glyphicon glyphicon-info-sign"></i>
			        {{Request::session()->pull('status')}}
			    </div>
		    </div>
		@endif	
        <div class="col-md-4 col-md-offset-4 white-boxed">
            <h3>Hi {{$request['name']}}</h3>
            <hr>
            <p>We noticed you already have an account setup with <strong>{{$request['email']}}</strong> on Skillsearch.</p>
            <p>If you will like to have access to the same account with your <strong>{{ucfirst($request['provider'])}}</strong> login, please enter your password below to confirm or <a href="/login">click here to login</a></p>
            <hr>
            <form method="post" action="{{Request::fullUrl()}}">
            	{{csrf_field()}}
            	<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
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
            	<button class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
