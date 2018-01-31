@extends('layouts.dashboard')

@section('title', 'Applications')
@section('content')

<h1 class="title is-3">
	{{ count($tasks) }} Saved {{ str_plural('Job', count($tasks)) }}
</h1>
<div class="subtitle is-6">Quickly find updates with your saved jobs</div>
@include('task.menu')
@if(count($tasks) > 0)
	@each('task.partials.task', $tasks, 'task')
@else
	<h4 class="ui red header">You have no saved jobs</h4>
@endif

@endsection