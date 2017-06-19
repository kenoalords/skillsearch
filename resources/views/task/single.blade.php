@extends('layouts.app')

@section('title', $task['title'])
@section('metadescription', e(str_limit($task['description'], 150)))
@section('type', 'article')

@section('content')

@if($task['profile']['verified'] === false)
    @include('includes.identity-warning', ['name'=>$task['profile']['fullname']])
@endif
                
<div class="container">
    <div class="row padded" style="background: #fff">
        <div class="col-md-10 col-md-offset-1">
            @if($task['is_approved'] === 1)
                @include('task.partials.single-task', ['task'=>$task])
            @else
                <h1>{{$task['title']}}</h1>

                <ul class="list-inline" style="font-size: .875em">
                    <li><img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="img-circle" width="16" height="16"> <span class="bold"><a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a></span></li>
                    <li>in <a href="#" class="bold">{{$task['category']}}</a></li>
                    <li class="bold"><i class="fa fa-map-marker"></i> {{$task['location']}}</li>
                    <li class="bold">{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}</li>
                    <li class="bold"><em>{{$task['date']}}</em></li>
                    @if($task['budget'])
                        <li class="pull-right">
                            <span class="budget bold">₦{{ number_format($task['budget']) }}</span>
                        </li>
                    @endif
                    @if($task['budget_type'])
                        <li class="bold">**{{ $task['budget_type'] }}</li>
                    @endif
                </ul>
                <p class="label label-warning">Pending Approval</p>
                <hr>
                

                @if(Auth::user() && Auth::user()->is_admin === 1)
                    <p>{!! nl2br($task['description']) !!}</p>
                    <job-actions task="{{ json_encode(['id'=>$task['id']]) }}"></job-actions>
                @else
                    <p>We are yet to verfiy this job, please check back later. <a href="{{ route('tasks') }}" class="bold">Browse other jobs</a></p>
                @endif
            @endif
        </div>
    </div>

    @if(count($others) > 0)
    <hr>
    <div class="row padded" style="background: #fff" id="jobs">
        <div class="col-md-10 col-md-offset-1">
            <h4 class="container-fluid bold" style="margin-bottom: 0">Other Jobs<hr></h4>
            @each('task.partials.task', $others, 'task')
        </div>
    </div>
    @endif
</div>
@endsection
