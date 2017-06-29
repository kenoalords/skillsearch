@extends('layouts.app')

@section('title', 'Find Jobs')
@section('metadescription', 'Find quick jobs matching your skills on ' . config('app.name') . ' and earn more.')
@section('type', 'article')

@section('content')



<div class="container padded">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <h1><span class="bold">Find</span> <span class="thin">Quick Jobs</span></h1>
            <p>Discover quick jobs matching your skills</p>
            @include('search.partials.job-search-form', ['skills'=>$skills])
        </div>
    </div>
    <hr>
    <div class="row" id="jobs">
        <div class="col-md-10 col-md-offset-1">
            @if ( count($tasks) > 0 )
                @each('task.partials.task', $tasks, 'task')
            @else
                <div class="text-center">
                    <h1><span class="bold">Fresh</span> &amp; <span class="thin">Clean</span></h1>
                    <p>No jobs have been submitted yet, please check back later</p>
                    <p><a href="{{route('add_task')}}" class="btn btn-success">Submit your job</a></p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
