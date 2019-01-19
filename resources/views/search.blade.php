@extends('layouts.app')
@section('title', Request::get('term') )
@section('content')

<div class="section">
	<div class="container">
		@if(count($portfolios) > 0)
			<h1 class="title is-4">{{Request::get('term')}} - {{count($portfolios)}} match found</h1>
			<div class="columns is-multiline is-mobile">
				@each('includes.portfolio-with-user', $portfolios, 'portfolio')
			</div>
		@else
			<h1 class="title is-4">Nothing found!</h1>
			<p>You can help grow our community by inviting your friends.</p>
			<p>
				<a href="/invite" class="button is-success">
					<span class="icon"><i class="fa fa-google-plus"></i></span>
					<span>Invite your friends from Gmail</span>
				</a>
			</p>
		@endif
	</div>
</div>

@include('includes.signup-teaser')

@include('includes.skills')
@endsection
