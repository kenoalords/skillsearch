@extends('layouts.app')
@section('title', 'Jobs')
@section('content')
<div class="container">

    <div class="row" style="margin-top: 2em">
        @include('task.partials.navigation', ['page'=>'index'])
    </div>

    <div class="row padded" id="jobs">
        <div class="col-md-10 col-md-offset-1">
            <div class="clearfix">
                <h2 class="pull-left">Jobs</h2>
            </div>
            <hr>
            
            @if ( count($tasks) > 0 )
                @each('task.partials.task', $tasks, 'task')
            @else
                <p>You have not submitted any job yet</p>
            @endif
        </div>
    </div>
</div>
@endsection
