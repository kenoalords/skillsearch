@extends('layouts.admin')

@section('title', 'Apply for ' . $task['title'])
@section('metadescription', 'Submit an application for ' . $task['title'])
@section('type', 'article')

@section('content')

<div class="ui container grid">
	@if($task['profile']['verified'] === false)
        @include('includes.identity-warning', ['name'=>$task['profile']['fullname']])
    @endif
	@if(Auth::user() && Auth::user()->id === $task['user_id'])
		<div class="ui icon warning message">
			<i class="icon warning sign"></i>
			<div class="content">
				<div class="header">Oops!</div>
				<p>You cannot apply for your own job or can you? <a href="{{ url()->previous() }}" class=""><i class="icon arrow left"></i> Go Back</a></p>
			</div>
		</div>
	@else
		@if ( count($user['portfolios']) < 3 )
			@if($task['closed'] !== 1)
			<div class="ui icon warning message">
				<i class="icon lock"></i>
			    <div class="content">
			    	<div class="header">You need a minimum of 3 portfolio items uploaded to enable you apply for this job.</div>
			    </div>
			</div>
			@endif
		@else
			@if(!$applied)
				@if( $task['application_limit'] > 0 && $task['application_limit'] !== -1 )
					@if( $task['application_left'] > 0 && $task['closed'] !== 1 )
						<task-form-apply task="{{ json_encode($task) }}" style="margin-top: 3em"></task-form-apply>
					@else
						<div class="ui icon info message">
							<i class="icon info circle"></i>
						    <div class="content">
						    	<div class="header">Application Limit Reached!</div>
						    	<p>We are sorry but you cannot apply for this job as the application limit has been reached.</p>
						    </div>
						</div>
					@endif
				@else
					@if($task['closed'] !== 1 )
						<task-form-apply task="{{ json_encode($task) }}"></task-form-apply>
					@endif
				@endif
    			
    		@else
    			<div class="ui icon info message">
    				<i class="icon check circle"></i>
				    <div class="content">
				        <div class="header">You have applied for this job already.</div>
				    </div>
				</div>
    		@endif
    	@endif
    @endif

    @if($task['closed'] === 1)
		<div class="container">
		    <div class="row padded" style="background: #fff; border: 1px solid #eee; margin-top: 3em">
		        <div class="col-md-10 col-md-offset-1 text-center">
					<h1 class="text-warning"><i class="fa fa-lock"></i> Job Closed!</h1>
					<p>We are no longer accepting applications for this job. Please check other jobs</p>
					<p>
						<a href="{{ url()->previous() }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go back</a>
					</p>
		        </div>
		    </div>
		</div>
	@endif
</div>

@endsection