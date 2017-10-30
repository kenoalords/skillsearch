@extends('layouts.admin')

@section('content')
@if(!$token)
	<div>
		<img src="{{ asset('public/instagram.jpg') }}" alt="Instagram" style="width: 300px; height: auto">
		<p>Link your Instagram account and showcase more of your works</p>
	</div>
	@if(Request::get('error'))
		<div class="ui warning message">
			<i class="fa fa-warning"></i> ERROR: {{ Request::get('error_description') }}
		</div>
	@endif
	<br>
	<p><a href="/profile/portfolio/instagram/get" class="ui icon labeled instagram button" id="google-invite"><i class="icon instagram"></i> Link my Instagram account</a></p>
@else
	<h2 class="ui header">Instagram Feed for <a href="https://instagram.com/{{$token->username}}" target="_blank">{{$token->full_name}}</a></h2>
	<div class="ui divider"></div>
	<instagram user="{{ Auth::user()->name }}"></instagram>
	<br>
	<a href="/profile/portfolio/instagram/delete" class="ui mini red button" id="delete-instagram">Click here to delete this account</a>
@endif
@endsection