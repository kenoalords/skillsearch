@extends('layouts.admin')

@section('title', 'Applications')
@section('content')

<h1 class="ui header">
	{{ count($tasks) }} Saved {{ str_plural('Job', count($tasks)) }}
	<div class="sub header">Quickly find updates with your saved jobs</div>
</h1>

@if(count($tasks) > 0)
	@each('task.partials.task', $tasks, 'task')
@else
	<h4 class="ui red header">You have no saved jobs</h4>
@endif

@endsection