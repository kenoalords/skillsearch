@extends('layouts.dashboard')

@section('title', 'Contact Request')

@section('content')
<h1 class="title is-3">
	Contact Requests
</h1>
<div class="subtitle is-6">See who has requested for your contact</div>
<contact-request pending="{{$pending}}" approved="{{$approved}}"></contact-request>

@endsection
