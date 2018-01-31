@extends('layouts.dashboard')

@section('title', 'Application Interests')
@section('content')
<h2 class="title is-4">Applications for {{ $task['title'] }}</h2>
<span class="subtitle is-size-6">Posted {{ $task['date'] }}</span>
<div class="level is-mobile">
	<div class="level-left">
		@if($task['closed'] !== 1)
		<a href="{{ route('task', ['task'=>$task['id'], 'slug'=>$task['slug']]) }}" class="level-item tag is-primary">View Job</a>
		<a href="{{ route('edit_task', ['task'=>$task['id']]) }}" class="level-item tag is-primary">Edit Job</a>
		@endif
		@if($task['closed'] === 1)
		<span class="level-item tag is-danger"><i class="fa fa-lock"></i> Closed</span>
		@endif
	</div>
</div>


<div>
	<h3 class="title is-4">{{ count($task['applications']) }} Job Applications</h3>
	@if(count($task['applications']) > 0 && $task['closed'] === 0)
	<div class="notification is-info is-small" role="alert">
		<i class="fa fa-info-circle"></i> <strong>NOTE:</strong> You can only accept <span class="bold">ONE</span> application
	</div>
	<div>
		@foreach ($task['applications'] as $application)
			<div class="media box is-raised">
				<div class="media-left">
					<a href="{{ route('view_profile', ['user'=>$application['profile']['username']]) }}">
						<img src="{{ $application['profile']['avatar'] }}" alt="{{ $application['profile']['fullname'] }}"  class="image is-48x48 is-rounded">
					</a>
				</div>
				<div class="media-content">
					<div class="content">
						<a href="{{ route('view_profile', ['user'=>$application['profile']['username']]) }}" class="author {{ ($application['profile']['verified']) ? 'verified' : '' }}">
							<strong>{{ $application['profile']['fullname'] }}</strong>
						</a>
						<small>{{ $application['date'] }}</small>
						@if($application['budget'])
							<span class="budget bold pull-right" style="font-size: 1.2em">₦{{$application['human_budget']}}</span>
						@endif
						
						<p class="text">{{ $application['application'] }}</p>
						
						<application-actions application="{{json_encode($application)}}"></application-actions>
					</div>
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