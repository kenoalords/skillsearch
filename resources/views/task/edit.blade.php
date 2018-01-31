@extends('layouts.dashboard')

@section('content')
<div class="">
    <task-form skills="{{$skills}}" edit="{{$task}}"></task-form>
</div>
@endsection