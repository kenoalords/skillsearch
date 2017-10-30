@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', config('app.name') . ' is a community of skilled people showcasing their awesome talent and getting hired.')
@section('title', 'About')
@section('content')
	
	<div id="points-header" class="page ui centered grid">
		<h1 class="ui large header">About</h1>
	</div>
	<div id="page" class="ui centered grid container">
		<div class="fourteen wide mobile eight wide tablet six wide computer column">
			<div class="padded">
				<!-- <h3>What are you good at?</h3> -->
				<p>
					{{config('app.name')}} is a community of creative people showcasing their awesome works and getting hired.
				</p>

				<p>
					With the ever increasing demand for creative services in Nigeria, {{config('app.name')}} provides an innovative and interactive online platform to help people showcase their works across various categories and get hired.
				</p>

				<p>
					{{config('app.name')}} is designed and maintained by <a href="http://clickmedia.com.ng">Clickmedia Solutions</a>
				</p>

				@if(!Auth::user())
				<a href="/register" class="btn btn-primary">Create a FREE account</a>
				@endif
			</div>
		</div>
	</div>

@endsection