@extends('layouts.app')

@section('content')

<div class="container padded">
	<div class="col-md-12">
		<div class="clearfix">
			<h2 class="pull-left"><span class="bold">Service Requests</span> | <span class="thin">Inbox</span></h2>
			<h2 class="pull-right"><small style="font-size: 14px"><a href="/home">Back to profile</a></small></h2>
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
