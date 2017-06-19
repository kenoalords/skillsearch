@extends('layouts.app')

@section('content')
<div class="container">
    <task-form skills="{{$skills}}" edit="{{$task}}"></task-form>
</div>
@endsection