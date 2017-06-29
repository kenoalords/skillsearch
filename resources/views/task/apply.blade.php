@extends('layouts.app')

@section('title', 'Apply for ' . $task['title'])
@section('metadescription', 'Submit an application for ' . $task['title'])
@section('type', 'article')

@section('content')

<div>
	@if($task['profile']['verified'] === false)
        @include('includes.identity-warning', ['name'=>$task['profile']['fullname']])
    @endif
	@if(Auth::user() && Auth::user()->id === $task['user_id'])
		<div class="container">
		    <div class="row padded" style="background: #fff; border: 1px solid #eee; margin-top: 3em">
		        <div class="col-md-10 col-md-offset-1 text-center">
					<h1><i class="fa fa-warning"></i> Oops!</h1>
					<p>You cannot apply for your own job or can you?</p>
					<p><a href="{{ url()->previous() }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go Back</a></p>
		        </div>
		    </div>
		</div>
	@else
		@if ( count($user['portfolios']) < 0 )
			@if($task['closed'] !== 1)
			<div class="container">
			    <div class="row padded" style="background: #fff; border: 1px solid #eee; margin-top: 3em">
			        <div class="col-md-10 col-md-offset-1 text-center">
						<h1 class="text-danger"><i class="fa fa-lock"></i> Locked!</h1>
						<p>You need a minimum of 3 portfolio items uploaded to enable you apply for this job.</p>
						<p>
							<a href="{{ route('portfolio_index') }}" class="btn btn-primary">Update your portfolio</a>
							<a href="{{ url()->previous() }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go back</a>
						</p>
			        </div>
			    </div>
			</div>
			@endif
		@else
			@if(!$applied)
				@if( $task['application_limit'] > 0 && $task['application_limit'] !== -1 )
					@if( $task['application_left'] > 0 && $task['closed'] !== 1 )
						<task-form-apply task="{{ json_encode($task) }}" style="margin-top: 3em"></task-form-apply>
					@else
						<div class="container">
						    <div class="row padded" style="background: #fff; border: 1px solid #eee; margin-top: 3em">
						        <div class="col-md-10 col-md-offset-1 text-center">
									<h1 class="text-warning"><i class="fa fa-warning"></i> Application Limit Reached!</h1>
									<p>We are sorry but you cannot apply for this job as the application limit has been reached.</p>

									<p>
										<a href="/jobs" class="btn btn-default"><i class="fa fa-arrow-left"></i> Find other jobs</a>
									</p>
						        </div>
						    </div>
						</div>
					@endif
				@else
					@if($task['closed'] !== 1 )
						<task-form-apply task="{{ json_encode($task) }}"></task-form-apply>
					@endif
				@endif
    			
    		@else
    			<div class="container">
				    <div class="row padded" style="background: #fff; border: 1px solid #eee; margin-top: 3em">
				        <div class="col-md-10 col-md-offset-1 text-center">
							<h1 class="text-warning"><i class="fa fa-warning"></i> Applied!</h1>
							<p>You have applied for this job already.</p>
							<p>
								<a href="{{ url()->previous() }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go back</a>
							</p>
				        </div>
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