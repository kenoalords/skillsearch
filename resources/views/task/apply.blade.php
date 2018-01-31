@extends('layouts.dashboard')

@section('title', 'Apply for ' . $task['title'])
@section('metadescription', 'Submit an application for ' . $task['title'])
@section('type', 'article')

@section('content')

@if($task['profile']['verified'] === false)
   @include('includes.identity-warning', ['name'=>$task['profile']['fullname']])
@endif
@if(Auth::user() && Auth::user()->id === $task['user_id'])
	<div class="notification is-danger">
		<p>You cannot apply for your own job or can you? <a href="{{ url()->previous() }}" class=""><span class="icon"><i class="fa fa-arrow-left"></i></span> <span>Go Back</span></a></p>
	</div>
@else
	@if ( count($user['portfolios']) < 3 )
		@if($task['closed'] !== 1)
		<div class="notification is-danger">
			You need a minimum of 3 portfolio items uploaded to enable you apply for this job.
		</div>
		@endif
	@else
		@if(!$applied)
			@if( $task['application_limit'] > 0 && $task['application_limit'] !== -1 )
				@if( $task['application_left'] > 0 && $task['closed'] !== 1 )
					<task-form-apply task="{{ json_encode($task) }}" style="margin-top: 3em"></task-form-apply>
				@else
					<div class="notification is-danger">
						We are sorry but you cannot apply for this job as the application limit has been reached.
					</div>
				@endif
			@else
				@if($task['closed'] !== 1 )
					<task-form-apply task="{{ json_encode($task) }}"></task-form-apply>
				@endif
			@endif
			
		@else
			<div class="notification is-info">
				You have applied for this job already.	
		</div>
		@endif
	@endif
@endif

@if($task['closed'] === 1)
	<h1 class="is-danger title is-5"><span class="icon"><i class="fa fa-lock"></i></span> <span>Job Closed!</span></h1>
	<p>We are no longer accepting applications for this job. Please check other jobs</p>
	<p>
		<a href="{{ url()->previous() }}" class="button is-primary">
			<span class="icon"><i class="fa fa-arrow-left"></i></span> 
			<span>Go back</span>
		</a>
	</p>
@endif
@endsection