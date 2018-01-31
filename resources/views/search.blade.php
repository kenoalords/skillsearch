@extends('layouts.app')
@section('title', Request::get('term') )
@section('content')
<div class="hero is-dark is-bold">
	<div class="hero-body">
		<div class="columns is-centered">
			<div class="column is-6">
				@include('search.people-search-form') 
			</div>
		</div>
	</div>
</div>


<div class="hero">
	<div class="hero-body">
	@if(count($portfolios) > 0)
	<div class="columns is-centered">
		<div class="column is-10">
			<h1 class="title is-4">{{Request::get('term')}} - {{count($portfolios)}} match found</h1>
			<div class="columns is-multiline">
				@each('includes.portfolio-with-user', $portfolios, 'portfolio')
			</div>
		</div>
	</div>
	@else
	<div class="hero">
		<div class="hero-body has-text-centered">
			<h1 class="title is-2">
				Nothing found!
			</h1>
			<p>You can help grow our community by inviting your friends.</p>
			<p>
				<a href="/invite" class="button is-success">
					<span class="icon"><i class="fa fa-google-plus"></i></span>
					<span>Invite your friends from Gmail</span>
				</a>
			</p>
		</div>
	</div>
	@endif
    </div>
</div>

@include('includes.skills')
@endsection
