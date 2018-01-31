@extends('layouts.dashboard')
@section('title', 'Likes')
@section('content')


<div class="">
	<h1 class="title is-3">Likes</h1>
	<p class="subtitle is-6">List of all the portfolios you've liked</p>
	@include('portfolio.menu')
	@if(count($portfolios) > 0)
	<div class="columns is-multiline">
		@each('includes.portfolio-with-user', $portfolios, 'portfolio')
	</div>
	@endif
</div>

@endsection