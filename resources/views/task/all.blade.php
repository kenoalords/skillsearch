@extends('layouts.app')

@section('title', 'Jobs')
@section('metadescription', 'Find quick jobs matching your skills on ' . config('app.name') . ' and earn more.')
@section('type', 'article')

@section('content')



<div>
    <div class="hero is-dark">
        <div class="hero-body">
            <div class="columns is-centered">
                <div class="column is-6 has-text-centered">
                    <h1 class="title is-3">Search Jobs</h1>
                    <h4 class="subtitle is-6">Find quick jobs matching your skills</h4>
                    @include('search.partials.job-search-form', ['skills'=>$skills])  
                </div>
            </div>
        </div>
    </div>
    
    <div class="hero is-medium">
        <div class="hero-body">
            <div class="columns is-centered">
                <div class="column is-8">
                    @if ( count($tasks) > 0 )
                        <div class="">
                            @each('task.partials.task', $tasks, 'task')
                        </div>
                    @else
                        <div>
                            <h4 class="title is-4 has-text-danger">No jobs have been submitted yet, please check back later</h4>
                        </div>
                    @endif
                </div>
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
