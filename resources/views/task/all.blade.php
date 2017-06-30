@extends('layouts.app')

@section('title', 'Find Jobs')
@section('metadescription', 'Find quick jobs matching your skills on ' . config('app.name') . ' and earn more.')
@section('type', 'article')

@section('content')



<div class="container padded">
    <div class="row" style="margin-bottom: 3em">
        <div class="col-md-8 col-md-offset-2 text-center">
            <h1><span class="bold">Find</span> <span class="thin">Quick Jobs</span></h1>
            <p>Discover quick jobs matching your skills</p>
            @include('search.partials.job-search-form', ['skills'=>$skills])
        </div>
    </div>
    
    <div class="container-fluid whiteCard" id="jobs">
        <div class="col-md-10 col-md-offset-1">
            @if ( count($tasks) > 0 )
                @each('task.partials.task', $tasks, 'task')
            @else
                <div class="text-center" style="padding: 3em">
                    <h2 class="text-warning"><i class="fa fa-warning"></i></h2>
                    <h4 class="text-warning">No jobs have been submitted yet, please check back later</h4>
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid text-center padded">
        <h1><i class="fa fa-hand-o-down"></i></h1>
        <h2>Do you have an upcoming project or job?</h2>
        <p>Let the best hands come to you. <a href="{{ route('add_task') }}" class="btn btn-sm btn-success">Submit Your Project Today</a></p>
    </div>
</div>
@endsection
