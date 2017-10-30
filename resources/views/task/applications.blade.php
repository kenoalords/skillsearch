@extends('layouts.admin')

@section('title', 'Applications')
@section('content')

<div>
	<h1 class="ui header">
		{{ count($applications) }} Job {{ str_plural('Application', count($applications)) }}
		<div class="sub header">Stay up to date with all your applications</div>
	</h1>
	@if(count($applications) > 0)
		@foreach ( $applications as $application )
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
    	@endforeach

	@else
		<h4 class="ui red header">You have not applied for any jobs on {{ config('app.name') }}</h4>
    @endif
</div>

@endsection