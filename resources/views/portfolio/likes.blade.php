@extends('layouts.dashboard')
@section('title', 'Likes')
@section('content')


<div class="">
	<h1 class="title is-3 is-size-5-mobile">Likes</h1>
	<p class="subtitle is-6">List of all the portfolios you've liked</p>
	@include('portfolio.menu')
	@if(count($portfolios) > 0)
	<div class="columns is-multiline is-mobile">
		@each('includes.portfolio-with-user', $portfolios, 'portfolio')
	</div>
	@else
		<h4 class="title is-5 has-text-danger">You have not liked any portfolio</h4>
	@endif
</div>

@endsection