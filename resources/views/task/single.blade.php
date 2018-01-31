@extends('layouts.app')

@section('title', $task['title'])
@section('metadescription', e(str_limit($task['description'], 150)))
@section('type', 'article')

@section('content')





@if($task['is_approved'] === 1)
    @include('task.partials.single-task', ['task'=>$task])
@else
    <div class="hero is-light">
        <div class="hero-body">
            <div class="columns is-centered">
                <div class="column is-8">
                    <h1 class="title is-2">{{$task['title']}}</h1>

                    <div class="level">
                        <div class="level-left is-mobile">
                            <div class="level-item"><img src="{{$task['profile']['avatar']}}" alt="{{$task['profile']['fullname']}}" class="image is-rounded is-24x24"> <a href="/{{ $task['profile']['username'] }}" class="{{ ($task['profile']['verified']) ? 'verified' : '' }}">{{ $task['profile']['fullname'] }}
                            </a></div>
                            <div class="level-item">in {{$task['category']}}</div>
                            <div class="level-item"><i class="fa fa-map-marker"></i> {{$task['location']}}</div>
                            <div class="level-item">{{count($task['applications'])}} {{ str_plural( 'Application', count($task['applications']) ) }}</div>
                            <div class="level-item">{{$task['date']}}</div>
                        </div>
                        
                        </div>
                        <p class="tag is-danger"><span class="icon"><i class="fa fa-warning"></i></span> <span>Pending Approval</span></p>
                        

                        @if(Auth::user() && Auth::user()->is_admin === 1)
                            <p>{!! nl2br($task['description']) !!}</p>
                            <job-actions task="{{ json_encode(['id'=>$task['id']]) }}"></job-actions>
                        @else
                            <p>We are yet to verfiy this job, please check back later. <a href="{{ route('tasks') }}" class="has-text-weight-bold has-text-link">Browse other jobs</a></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    

@if(count($others) > 0)
<div class="hero is-white is-medium">
    <div class="hero-body">
        <div class="columns is-centered">
            <div class="column is-8">
                <h4 class="title is-4">Other Jobs</h4>
                @each('task.partials.task', $others, 'task')
            </div>
        </div>
    </div>
</div>
@endif

<div class="hero is-primary">
    <div class="hero-body has-text-centered">
        <h2 class="title is-3">Do you have an upcoming job?</h2>
        <p><a href="{{ route('add_task') }}" class="button is-primary is-raised"><span>Submit your job</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span></a></p>
    </div>
</div>

@endsection
