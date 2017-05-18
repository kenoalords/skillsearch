@extends('layouts.app')

@section('content')
<div class="container padded">

	@include('search-form') 
	
	@if($profiles->count())
	<div class="row">
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
