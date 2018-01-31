@extends('layouts.app')

@section('title', 'Search for ' . Request::get('skill'))
@section('content')
<dic class="hero is-dark">
	<div class="hero-body">
		<div class="columns is-centered">
			<div class="column is-6">
				@include('search.partials.job-search-form', ['skills'=>$skills]) 
			</div>
		</div>
	</div>
</dic>

<div class="hero is-medium">
	<div class="hero-body">
		@if(count($tasks) > 0)
		<div class="columns is-centered">
			<div class="column is-8">
				<h1 class="title is-3">We found {{count($tasks)}} {{ str_plural('job', count($tasks)) }} matching your search</h1>
				@each('task.partials.task', $tasks, 'task')
			</div>
		</div>
		@else
		<div class="columns is-centered">
			<div class="column is-8 has-text-centered">
				<h1 class="title is-3">No jobs found</h1>
				<p>Sorry we couldn't find any result matching your search criteria but you can help by inviting your friends to grow our community.</p>
				<p>
					<a href="/invite" class="button is-success">
						<span class="icon"><i class="fa fa-google-plus"></i> </span>
						<span>Invite your friends from Gmail</span>
					</a>
				</p>
			</div>
		</div>
		@endif
    </div>
</div>
@endsection
