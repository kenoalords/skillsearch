@extends('layouts.app')

@section('title', 'Find Jobs')
@section('metadescription', 'Find jobs matching your skills on ' . config('app.name') . ' and submit applications')
@section('type', 'article')

@section('content')

<div class="container">

    @if ( count($tasks) > 0 )
    <div class="row" style="margin-top: 3em">
        <h1 class="medium-header"><span class="bold">{{ count($tasks) }} Jobs</span> <span class="thin">For Approval</span></h1>
    </div>
    @endif

    <div class="row padded" id="jobs">
        <div class="col-md-10 col-md-offset-1">
            
            @if ( count($tasks) > 0 )
                @each('task.partials.task', $tasks, 'task')
            @else
                <div class="text-center">
                    <h1><span class="bold">Fresh</span> &amp; <span class="thin">Clean</span></h1>
                    <p>No jobs have been submitted for approval</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
