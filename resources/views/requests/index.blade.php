@extends('layouts.app')

@section('title', 'Messages')
@section('content')

<div class="container padded">
	<div class="col-md-10 col-md-offset-1">
		<div class="clearfix">
			<h4 class="pull-left"><span class="bold">Service</span> <span class="thin">Requests</span></h4>
			<span class="pull-right"><small style="font-size: 14px"><a href="/home" class="btn btn-default">Back to profile</a></small></span>
		</div>
		<hr>
		@if($requests)
			<requests requests="{{ $requests->getContent() }}"></requests>
		@endif

		@if(!$requests)
			<div class="padded text-center">
                <p style="font-size:3em"><i class="glyphicon glyphicon-thumbs-down"></i></p>
                <p>You have not received any service request yet</p>
            </div>
		@endif
	</div>
</div>

@endsection
