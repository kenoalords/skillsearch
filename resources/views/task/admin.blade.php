@extends('layouts.admin')

@section('title', 'Find Jobs')
@section('metadescription', 'Find jobs matching your skills on ' . config('app.name') . ' and submit applications')
@section('type', 'article')

@section('content')

@if ( count($tasks) > 0 )
    <h2 class="ui header">{{ count($tasks) }} Jobs for Approval</h2>
@endif

@if ( count($tasks) > 0 )
    @each('task.partials.task', $tasks, 'task')
@else
    <h2 class="ui red header">No jobs for approval</h2>
@endif

@endsection
