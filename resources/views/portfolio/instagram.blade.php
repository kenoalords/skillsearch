@extends('layouts.dashboard')

@section('content')
@if(!$token)
	<div>
		<img src="{{ asset('public/instagram.jpg') }}" alt="Instagram" style="width: 300px; height: auto">
		<p>Link your Instagram account and showcase more of your works</p>
	</div>
	@if(Request::get('error'))
		<div class="notification is-info">
			<i class="fa fa-warning"></i> ERROR: {{ Request::get('error_description') }}
		</div>
	@endif
	<br>
	<p><a href="/dashboard/portfolio/instagram/get" class="button is-primary" id="google-invite"><i class="fa fa-instagram"></i>&nbsp; Link my Instagram account</a></p>
@else
	<h2 class="title is-3">Instagram Feed for <a href="https://instagram.com/{{$token->username}}" target="_blank">{{$token->full_name}}</a></h2>
	@include('portfolio.menu')
	<instagram user="{{ Auth::user()->name }}"></instagram>
	<br>
	<a href="/dashboard/portfolio/instagram/delete" class="button is-danger" id="delete-instagram">Click here to delete this account</a>
@endif
@endsection