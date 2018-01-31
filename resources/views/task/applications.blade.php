@extends('layouts.dashboard')

@section('title', 'Applications')
@section('content')

<div>
	<h1 class="title is-3">
		{{ count($applications) }} Job {{ str_plural('Application', count($applications)) }}
	</h1>
	<div class="subtitle is-6">Stay up to date with all your applications</div>
	@include('task.menu')
	@if(count($applications) > 0)
		@foreach ( $applications as $application )
    			<div class="card is-raised">
    				<div class="card-content">
    					<h3 class="title is-4">
    						<span class="icon"><i class="fa fa-user"></i></span>
    						<span>{{ $application['task'][0]['title'] }}</span> 
    					</h3>
    					<div class="level is-mobile">
    						<div class="level-left">
    							<div class="level-item">
    								<img src="{{ $application['task'][0]['profile']['avatar'] }}" alt="{{ $application['task'][0]['profile']['fullname'] }}" class="image is-24x24 is-rounded is-inline"> <a href="{{ route('view_profile', ['user' => $application['task'][0]['profile']['username']]) }}">{{ $application['task'][0]['profile']['fullname'] }}</a>
    							</div>
    							<div class="level-item">
    								{{ $application['task'][0]['category'] }}
    							</div>
    							<div class="level-item">
    								<span class="icon"><i class="fa fa-map-marker"></i></span> 
    								<span>{{ $application['task'][0]['location'] }}</span>
    							</div>
    							<div class="level-item">
    								Posted {{ $application['task'][0]['date'] }}
    							</div>
    						</div>
    					</div>

    					<div class="box">
    						<p>{{ $application['application'] }}</p>
    						<p class="has-text-grey">You submitted this {{ $application['date'] }}</p>
    					</div>
					
					@if(count($application['responses']) > 0)
					<application-actions application="{{json_encode($application)}}"></application-actions>
					@endif
				</div>
			</div>
    	@endforeach

	@else
		<h4 class="ui red header">You have not applied for any jobs on {{ config('app.name') }}</h4>
    @endif
</div>

@endsection