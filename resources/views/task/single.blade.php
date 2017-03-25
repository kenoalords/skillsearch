@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div>
                    <h1> {{ $task->title }} </h1>
                    <p><span class="text-muted">{{ $task->created_at->diffForHumans() }}</span></p>
                    <p>{{ $task->description }}</p>
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
        </div>
    </div>
</div>
@endsection
