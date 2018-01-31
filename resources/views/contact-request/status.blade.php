@extends('layouts.account')

@section('title', 'Contact Request Sent')

@section('content')

<div class="hero">
	<div class="hero-body">
		@if(Request::get('status') === 'sent')
		<h4 class="title is-5">{{Request::get('sender')}}, your request has been sent to {{Request::get('name')}}</h4>
		<p>We will notify you once your request is approved.</p>
		@else
		<p>Oops! Something is not right</p>
		@endif
		<a href="{{ route('view_profile', ['user'=>Request::get('user')]) }}" class="is-primary button">Back to profile</a>
	</div>
</div>

@endsection
