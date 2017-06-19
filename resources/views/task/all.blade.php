@extends('layouts.app')

@section('title', 'Find Jobs')
@section('metadescription', 'Find quick jobs matching your skills on ' . config('app.name') . ' and earn more.')
@section('type', 'article')

@section('content')


@include('search.partials.job-search-form', ['skills'=>$skills]) 
<div class="container">

    <div class="row padded" id="jobs">
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
