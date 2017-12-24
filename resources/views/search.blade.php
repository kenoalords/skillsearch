@extends('layouts.app')
@section('title', Request::get('term') )
@section('content')

<div class="padded" style="margin-top: 6em">
	@include('search-form') 
</div>

<div class="">
	
	@if(count($portfolios) > 0)
	<div class="ui centered container grid">
		<div class="column">
			<h1 class="ui medium header">{{Request::get('term')}} - {{count($portfolios)}} match found</h1>
			<div class="ui divider"></div>
			<div class="ui grid">
				@each('includes.portfolio-with-user', $portfolios, 'portfolio')
			</div>
		</div>
	</div>
	@else
	<div class="ui centered container grid">
		<div class="center aligned column">
			<h1 class="ui icon header">
				<i class="icon frown"></i>
				Nothing found!
			</h1>
			<p>You can help grow our community by inviting your friends.</p>
			<p><a href="/invite" class="ui icon labeled google plus button"><i class="icon google plus"></i> Invite your friends from Gmail</a></p>
		</div>
	</div>
	@endif
    
</div>
<div class="padded"></div>
@include('includes.skills')
@endsection
