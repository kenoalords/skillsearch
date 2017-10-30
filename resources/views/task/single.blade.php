@extends('layouts.app')

@section('title', $task['title'])
@section('metadescription', e(str_limit($task['description'], 150)))
@section('type', 'article')

@section('content')

@if($task['profile']['verified'] === false)
    @include('includes.identity-warning', ['name'=>$task['profile']['fullname']])
@endif
                
<div class="" style="margin-top: 6em;">
    <div class="ui container grid">
        <div class="twelve wide column">
            @if($task['is_approved'] === 1)
                @include('task.partials.single-task', ['task'=>$task])
            @else
                <h1 class="ui header">{{$task['title']}}</h1>

                <div class="ui horizontal list" style="font-size: .875em">
                    <div class="item"><img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="ui avatar image" width="16" height="16"> <a href="{{ config('app.url') . '/' . $task['profile']['username'] }}">{{ $task['profile']['fullname'] }} {!! identity_check($task['profile']['verified']) !!}</a></div>
                    <div class="item">in <a href="#" class="bold">{{$task['category']}}</a></div>
                    <div class="item"><i class="fa fa-map-marker"></i> {{$task['location']}}</div>
                    <div class="item">{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}</div>
                    <div class="item">{{$task['date']}}</div>
                    @if($task['budget'])
                        <div class="item">
                            <span class="budget item">₦{{ number_format($task['budget']) }}</span>
                        </div>
                    @endif
                    @if($task['budget_type'])
                        <div class="item">**{{ $task['budget_type'] }}</div>
                    @endif
                </div>
                <p class="label label-warning">Pending Approval</p>
                

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
    
    <div class="ui container grid" style="margin-top: 3em;">
        <div class="twelve wide column">
            <h4 class="ui grey dividing header">Other Jobs</h4>
            @each('task.partials.task', $others, 'task')
        </div>
    </div>
    @endif

    <div class="ui center aligned padded grid" style="margin-top: 3em !important;">
        <div class="white padded column">
            <h2 class="ui header">Do you have an upcoming job?</h2>
            <a href="{{ route('add_task') }}" class="ui green button">Post a job</a>
        </div>
    </div>
</div>
@endsection
