@extends('layouts.app')

@section('content')
@if(!$token)
	<div class="white-boxed">
		<div class="text-center">
			<img src="{{ asset('public/instagram.jpg') }}" alt="Instagram">
			<div>
				<!-- <h3 class="thin">Using Instagram to showcase your skills?</h3> -->
				<p>Link your Instagram account and showcase more of your works</p>
			</div>
		</div>
	</div>
	<div class="padded container">
		<div class="text-center col-md-4 col-md-offset-4">
			@if(Request::get('error'))
				<div class="alert alert-danger">
					<i class="fa fa-warning"></i> ERROR: {{ Request::get('error_description') }}
				</div>
			@endif
			<p><a href="/profile/portfolio/instagram/get" class="btn btn-success" id="google-invite"><i class="fa fa-instagram"></i> Link Instagram Account</a></p>
		</div>
	</div>
@else
	<div class="padded">
		<div class="container">
			<div class="clearfix">
				<h2 class="pull-left"><i class="fa fa-instagram"></i> <span class="bold">Instagram</span> <span class="thin"> Feed for <a href="https://instagram.com/{{$token->username}}" target="_blank">{{$token->full_name}} <i class="fa fa-external-link"></i></span></h2>
				<p class="pull-right hidden-xs"><a href="/home" class="btn btn-basic">Back</a></p>
			</div>
			
			<hr>
			<instagram user="{{ Auth::user()->name }}"></instagram>
			<hr>
			<p><a href="/profile/portfolio/instagram/delete" class="btn btn-danger" id="delete-instagram">Click here to delete this account</a></p>
		</div>
	</div>
@endif
@endsection