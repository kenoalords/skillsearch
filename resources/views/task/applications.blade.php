@extends('layouts.app')

@section('title', 'Applications')
@section('content')

<div>
    <div class="container">
    	<div class="row" style="margin: 2em -15px">
    		@include('task.partials.navigation', ['page'=>'application'])
	    </div>
    	<div class="row padded" style="background: #fff;">
    		<div class="col-md-10 col-md-offset-1">
    			<div class="clearfix">
    				<h1 class="pull-left"><span class="bold">{{ count($applications) }} Job</span> <span class="thin">{{ str_plural('Application', count($applications)) }}</span></h1>
    			</div>
    			<hr>
    			<p>Stay updated with all your job applications</p>
    		</div>
    	</div>
		
		@if(count($applications) > 0)
		@foreach ( $applications as $application )
    	<div class="row padded" style="background: #fff; margin-top: 2em; border: 1px solid #eee">
    		<div class="col-md-10 col-md-offset-1">
				<div>
					<p>{{ $application['application'] }}</p>
					<small><em>Submitted: {{ $application['date'] }}</em></small>
					<hr>
					<h5><span class="bold">Job Title: </span>{{ $application['task'][0]['title'] }} <small class="text-muted"><em>{{ $application['task'][0]['date'] }}</em></small></h5>
					<ul class="list-inline">
						<li>
							<span class="text-muted">by</span> <img src="{{ $application['task'][0]['profile']['avatar'] }}" alt="{{ $application['task'][0]['profile']['fullname'] }}" class="img-circle" width="24" height="24"> <a href="{{ route('view_profile', ['user' => $application['task'][0]['profile']['username']]) }}">{{ $application['task'][0]['profile']['fullname'] }}</a>
						</li>
						<li>{{ $application['task'][0]['category'] }}</li>
						<li><i class="fa fa-map-marker"></i> {{ $application['task'][0]['location'] }}</li>
					</ul>
					
					@if(count($application['responses']) > 0)
					<application-actions application="{{json_encode($application)}}"></application-actions>
					@endif

				</div>
    		</div>
    	</div>
    	@endforeach

		@else
			<div class="row padded" style="background: #fff; margin-top: 2em">
	    		<div class="col-md-10 col-md-offset-1">
					<p>You have not applied for any jobs on {{ config('app.name') }}</p>
				</div>
			</div>
    	@endif
    </div>
</div>

@endsection