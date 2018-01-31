@extends('layouts.dashboard')
@section('title', 'Jobs')
@section('content')

<h2 class="title is-2">Jobs</h2>
@include('task.menu')
@if ( count($tasks) > 0 )
	<div>
    		@each('task.partials.task', $tasks, 'task')
    </div>
@else
    <p>You have not submitted any job yet</p>
@endif

@endsection
