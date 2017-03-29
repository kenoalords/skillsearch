@extends('layouts.app')

@section('content')
<div class="padded">
	<div class="container">
		<div class="col-md-8 col-md-offset-2 white-boxed">
			<h2 class="thin">Confirm delete</h2>
			<p>Are you sure you want to delete this portfolio? All files related to this portfolio will be deleted.</p>
			<hr>
			<div class="row">
				<div class="col-md-4">
					<img src="{{$portfolio->getThumbnail()}}" class="img-responsive">
				</div>
				<div class="col-md-8">
					<h4>{{$portfolio->title}} <small>{{$portfolio->date}}</small></h4>
					<p>
						<a href="/profile/portfolio/{{$portfolio->uid}}/delete/ok" class="btn btn-danger btn-sm">Delete</a>
						<a href="/profile/portfolio" class="btn btn-basic btn-sm">Cancel</a>
					</p>
				</div>
			</div>	
		</div>		
	</div>
</div>

@endsection
