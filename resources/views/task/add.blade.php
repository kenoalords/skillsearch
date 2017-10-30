@extends('layouts.admin')
@section('title', 'Submit Job')
@section('content')
@if($user['verified'] === false)
    <div class="alert alert-danger text-center">
    	<i class="fa fa-warning"></i> You are yet to <a href="{{ route('verify_identity') }}" class="bold">verify your identity</a> and this job posting will be marked as unverified. <a href="{{ route('verify_identity') }}" class="bold">Click here to verify your identity</a>
    </div>
@endif
<div>
    <task-form skills="{{$skills}}"></task-form>
</div>

@endsection