@extends('layouts.app')

@section('title', 'Delete Job: ' . $task->title)
@section('content')
<div class="container" style="background: #fff; margin-top: 3em; border: 1px solid #eee;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 padded text-center">
            <h1 class="text-warning"><i class="fa fa-warning"></i></h1>
            <h3>Are you sure you want to delete this job</h3>
            <hr>
            <h4><a href="{{ route('task', ['task'=>$task->id, 'slug'=>$task->slug]) }}">{{$task->title}}</a></h4>
            <p>Proceding will delete all applications and responses permanently</p>
            <ul class="list-inline">
                <li><a href="{{ route('delete_task_ok', ['task'=>$task->id]) }}" class="btn btn-danger">Delete</a></li>
                <li><a href="{{ url()->previous() }}" class="btn btn-basic">Cancel</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection