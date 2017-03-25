@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            @if ( $tasks->count() )
                @foreach ( $tasks as $task )
                <div class="panel panel-default">
                <div class="panel-body">
                    <div class="clearfix">
                        <h4><a href="{{ route('task', ['task'=>$task->id, 'slug'=>$task->slug]) }}"> {{ $task->title }} </a></h4>
                        <p><span class="text-muted">{{ $task->created_at->diffForHumans() }}</span></p>
                        <p>{{ str_limit($task->description, 200) }}</p>
                        <hr>
                        <div class="">
                            <div class="pull-right">
                                <a href="{{ route('edit_task', ['task'=>$task->id]) }}" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                <a href="" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                            </div>
                            <div class="pull-left">
                                <a href="{{ route('edit_task', ['task'=>$task->id]) }}" class="btn btn-default"><i class="glyphicon glyphicon-stats"></i> Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                @endforeach
                <hr>
                <p><a href="{{route('add_task')}}" class="btn btn-default">Submit task</a></p>
            @else
                <p>No task has been submitted yet</p>
                <p><a href="{{route('add_task')}}" class="btn btn-default">Submit task</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
