@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', 'Skillsearch Nigeria is a community of skilled people showcasing their awesome talent and getting hired.')

@section('content')
	
	<div id="hero" class="page padded text-center">
		<h1>About Us</h1>
	</div>
	<div id="page" class="container">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="padded">
				<!-- <h3>What are you good at?</h3> -->
				<p>
					Skillsearch Nigeria is a community of skilled people showcasing their awesome talent and getting hired.
				</p>

				<p>
					With the ever increasing demand for skilled services in Nigeria, Skillsearch Nigeria provides an innovative and interactive online platform to help people showcase their skills across various categories and get hired.
				</p>

				@if(!Auth::user())
				<a href="/register" class="btn btn-primary">Sign up today</a>
				@endif
			</div>
		</div>
	</div>

@endsection