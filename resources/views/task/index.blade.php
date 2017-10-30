@extends('layouts.admin')
@section('title', 'Jobs')
@section('content')

<h2 class="ui header">Jobs</h2>
@if ( count($tasks) > 0 )
	<div class="ui divided very relaxed list">
    	@each('task.partials.task', $tasks, 'task')
    </div>
@else
    <p>You have not submitted any job yet</p>
@endif

@endsection
