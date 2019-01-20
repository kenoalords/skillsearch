@extends('layouts.dashboard')
@section('title', 'Email Broadcast')
@section('content')

<h1 class="title is-2">
	Send email broadcast
</h1>
<p class="sub header">Send a general message to all registered members</p>

<email-broadcast></email-broadcast>

@endsection
