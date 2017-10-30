@extends('layouts.admin')
@section('title', 'Delete Portfolio')
@section('content')
<div class="padded">
	<div class="container">
		<div>
			<h2 class="ui warning header">
				Confirm delete
				<p class="sub header">Are you sure you want to delete this portfolio? All files related to this portfolio will be deleted.</p>
			</h2>
			
			<div class="ui divider"></div>
			<div class="ui card">
				<div class="image">
					<img src="{{$portfolio->getThumbnail()}}" class="img-responsive">
				</div>
				<div class="content">
					<h4 class="header">{{$portfolio->title}}</h4>
					{{$portfolio->date}}
					
				</div>
				<div class="extra content">
					<a href="/profile/portfolio/{{$portfolio->uid}}/delete/ok" class="ui mini red button">Delete</a>
					<a href="/profile/portfolio" class="btn btn-basic btn-sm">Cancel</a>
				</div>
			</div>	
		</div>		
	</div>
</div>

@endsection
