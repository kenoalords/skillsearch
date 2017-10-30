@extends('layouts.admin')

@section('title', 'Application Interests')
@section('content')
<h1 class="ui header">Job Applications</h1>
<div class="ui divider"></div>

<h2 class="ui grey header">{{ $task['title'] }}</h2>
<span class="text-muted">Posted {{ $task['date'] }}</span>
<p>{{ $task['excerpt'] }}</p>
<ul>
	@if($task['closed'] !== 1)
	<li><a href="{{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}">View Job</a></li>
	<li><a href="{{ route('edit_task', ['task'=>$task['id']]) }}">Edit Job</a></li>
	@endif
	@if($task['closed'] === 1)
	<li><span class="label label-success"><i class="fa fa-lock"></i> Closed</span></li>
	@endif
</ul>

<div class="ui divider"></div>
<div>
	<h3 class="ui header">{{ count($task['applications']) }} Job Applications</h3>
	@if(count($task['applications']) > 0 && $task['closed'] === 0)
	<div class="alert alert-info alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<i class="fa fa-info-circle"></i> <strong>NOTE:</strong> You can only accept <span class="bold">ONE</span> application
	</div>
	<div id="applications">
		@foreach ($task['applications'] as $application)
			<div class="media">
				<div class="media-left">
					<a href="{{ route('view_profile', ['user'=>$application['profile']['username']]) }}">
						<img src="{{ $application['profile']['avatar'] }}" alt="{{ $application['profile']['fullname'] }}" class="media-object img-circle" width="48" height="48">
					</a>
				</div>
				<div class="media-body">
					<h5 class="media-heading bold">
						<a href="{{ route('view_profile', ['user'=>$application['profile']['username']]) }}">
							{{ $application['profile']['fullname'] }} {!! identity_check($application['profile']['verified']) !!}
						</a>
						<small class="text-muted bold text-italic">{{ $application['date'] }}</small>
					</h5>
					@if($application['budget'])
						<span class="budget bold pull-right" style="font-size: 1.2em">₦{{$application['human_budget']}}</span>
					@endif
					
					<p>{{ $application['application'] }}</p>
					
					<application-actions application="{{json_encode($application)}}"></application-actions>
				</div>
			</div>
		@endforeach
	</div>
	@elseif (count($task['applications']) === 0)
	<p>You have not received any applications for this job</p>
	@endif

	@if($task['closed'] === 1)
	<p>This job is closed</p>
	@endif
</div>
@endsection