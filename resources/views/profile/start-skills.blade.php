@extends('layouts.account')
@section('title', 'Select your skills')
@section('content')

<div class="hero">
    <div class="hero-body">
		<skills></skills>
		<div>
			<p><a href="/dashboard" class="button is-primary is-block"><span>Continue</span> <span class="icon"><i class="fa fa-arrow-right"></i></span></a></p>
			<a href="/dashboard" class="button is-white is-block"><span>Skip</span></a>
		</div>
    </div>
</div>
@endsection
