@extends('layouts.admin')

@section('title', 'Application Interests')
@section('content')
<h2 class="ui header">Applications for {{ $task['title'] }}</h2>
<span class="text-muted">Posted {{ $task['date'] }}</span>
<div class="ui horizontal list">
	@if($task['closed'] !== 1)
	<div class="item"><a href="{{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}">View Job</a></div>
	<div class="item"><a href="{{ route('edit_task', ['task'=>$task['id']]) }}">Edit Job</a></div>
	@endif
	@if($task['closed'] === 1)
	<div class="item"><span class="label label-success"><i class="fa fa-lock"></i> Closed</span></div>
	@endif
</div>

<div class="ui divider"></div>
<div>
	<h3 class="ui header">{{ count($task['applications']) }} Job Applications</h3>
	@if(count($task['applications']) > 0 && $task['closed'] === 0)
	<div class="ui info message" role="alert">
		<i class="fa fa-info-circle"></i> <strong>NOTE:</strong> You can only accept <span class="bold">ONE</span> application
	</div>
	<div id="applications" class="ui comments">
		@foreach ($task['applications'] as $application)
			<div class="comment">
				<div class="avatar">
					<a href="{{ route('view_profile', ['user'=>$application['profile']['username']]) }}">
						<img src="{{ $application['profile']['avatar'] }}" alt="{{ $application['profile']['fullname'] }}" class="" width="48" height="48">
					</a>
				</div>
				<div class="content">
					<a href="{{ route('view_profile', ['user'=>$application['profile']['username']]) }}" class="author">
						{{ $application['profile']['fullname'] }} {!! identity_check($application['profile']['verified']) !!}
					</a>
					<small class="metadata">{{ $application['date'] }}</small>
					@if($application['budget'])
						<span class="budget bold pull-right" style="font-size: 1.2em">₦{{$application['human_budget']}}</span>
					@endif
					
					<p class="text">{{ $application['application'] }}</p>
					
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