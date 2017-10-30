@extends('layouts.admin')

@section('title', 'Messages')
@section('content')

<h1 class="ui header">Messages</h1>

@if($requests)
	<requests requests="{{ $requests->getContent() }}"></requests>
@endif

@if(!$requests)
	<h4 class="ui red header">You have not received any messages</h4>
@endif

@endsection
