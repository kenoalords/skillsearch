@extends('layouts.app')

@section('content')
@section('title', {{Request::get('term')}})
@include('search-form') 
<div class="container padded">
	
	@if(count($profiles) > 0)
	<div class="row">
		<h1 class="thin text-center medium-header">We found {{count($profiles)}} {{ str_plural('profile', count($profiles)) }} matching your search</h1>
		<hr>
		@each('profile.person-tag', $profiles, 'profile')
	</div>
	@else
	<div class="container-fluid">
		<div class="text-center">
			<h1 style="font-size: 6em"><i class="fa fa-frown-o"></i></h1>
			<h3 class="thin">Sorry we couldn't find any result matching your search criteria</h3>
			<p class="bold">But you can help by inviting your friends to grow our community.</p>
			<p><a href="/invite" class="btn btn-success"><i class="fa fa-envelope"></i> Invite your friends from Gmail</a></p>
		</div>
	</div>
	@endif
    
</div>
@endsection
