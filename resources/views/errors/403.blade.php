@extends('layouts.app')

@section('title', 'Unathorized Action!' )

@section('content')

<div class="section is-medium">
	<div class="container has-text-centered">
		<h1 class="title is-1 bold is-size-3-mobile">Hold it right there!</h1>
		<p>You are not allowed to perform this action. <a href="{{ url()->previous() }}">Click here to go back.</a></p>
	</div>
</div>


@endsection
