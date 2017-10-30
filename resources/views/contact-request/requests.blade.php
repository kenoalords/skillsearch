@extends('layouts.admin')

@section('title', 'Contact Request')

@section('content')
<h1 class="ui header" style="margin-bottom: 1em">
	Contact Requests
	<div class="sub header">See who has requested for your contact</div>
</h1>
<contact-request pending="{{$pending}}" approved="{{$approved}}"></contact-request>

@endsection
