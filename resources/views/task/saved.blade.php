@extends('layouts.app')

@section('title', 'Applications')
@section('content')

<div>
    <div class="container">
    	<div class="row" style="margin: 2em -15px">
    		@include('task.partials.navigation', ['page'=>'saved'])
	    </div>
    	<div class="row padded" style="background: #fff;">
    		<div class="col-md-10 col-md-offset-1">
    			<div class="clearfix">
    				<h1 class="pull-left"><span class="bold">{{ count($tasks) }} Saved</span> <span class="thin">{{ str_plural('Job', count($tasks)) }}</span></h1>
    			</div>
    			<hr>
    			<p>Quickly find updates with your saved jobs</p>
    		</div>
    	</div>
		
		@if(count($tasks) > 0)
			<div class="row padded" style="background: #fff; margin-top: 2em" id="jobs">
	    		<div class="col-md-10 col-md-offset-1">
					@each('task.partials.task', $tasks, 'task')
				</div>
			</div>
		@else
			<div class="row padded" style="background: #fff; margin-top: 2em">
	    		<div class="col-md-10 col-md-offset-1">
					<p>You have not saved any jobs on {{ config('app.name') }}</p>
				</div>
			</div>
    	@endif
    </div>
</div>

@endsection