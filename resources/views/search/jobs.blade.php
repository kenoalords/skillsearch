@extends('layouts.app')

@section('title', 'Search for ' . Request::get('skill'))
@section('content')
@include('search.partials.job-search-form', ['skills'=>$skills]) 
<div class="container padded">
	
	@if(count($tasks) > 0)
	<div class="row padded" style="background: #fff; border: 1px solid #eee">
		<div class="col-md-10 col-md-offset-1">
			<h1 class="thin medium-header">We found {{count($tasks)}} {{ str_plural('job', count($tasks)) }} matching your search</h1>
			<hr>
			@each('task.partials.task', $tasks, 'task')
		</div>
	</div>
	@else
	<div class="container-fluid">
		<div class="text-center">
			<h1 style="font-size: 6em"><i class="fa fa-frown-o"></i></h1>
			<h3 class="thin">Sorry we couldn't find any result matching your search criteria</h3>
			<p class="bold">But you can help by inviting your friends to grow our community.</p>
			<p><a href="/invite" class="btn btn-success"><i class="fa fa-envelope"></i> Invite your friends from Gmail</a></p>
		</div>
	</div>
	@endif
    
</div>
@endsection
