@extends('layouts.app')

@section('title', 'Jobs')
@section('metadescription', 'Find quick jobs matching your skills on ' . config('app.name') . ' and earn more.')
@section('type', 'article')

@section('content')



<div>
    <div class="ui centered grid" style="margin: 6em 0 3em">
        <div class="">
            <h1 class="ui header">
                Search Jobs
                <div class="sub header">Find quick jobs matching your skills</div>
            </h1>
            @include('search.partials.job-search-form', ['skills'=>$skills])
        </div>
    </div>
    
    <div class="white-boxed">
        <div class="ui container grid">
            <div class="column">
                @if ( count($tasks) > 0 )
                    <div class="ui divided very relaxed list">
                    @each('task.partials.task', $tasks, 'task')
                    </div>
                @else
                    <div class="text-center" style="padding: 3em">
                        <h2 class="text-warning"><i class="fa fa-warning"></i></h2>
                        <h4 class="text-warning">No jobs have been submitted yet, please check back later</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- <div class="container-fluid text-center padded">
        <h1><i class="fa fa-hand-o-down"></i></h1>
        <h2>Do you have an upcoming project or job?</h2>
        <p>Let the best hands come to you. <a href="{{ route('add_task') }}" class="btn btn-sm btn-success">Submit Your Project Today</a></p>
    </div> -->
</div>
@include('includes.signup-teaser')
@include('includes.skills')

@endsection
