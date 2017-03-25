@extends('layouts.app')

@section('content')
<div class="container">

	@include('search-form') 

	<div class="row">
		@each('profile.person-tag', $profiles, 'profile')

		
	</div>
    
</div>
@endsection
