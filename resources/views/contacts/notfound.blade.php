@extends('layouts.app')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('title', 'Unsubscribe')
@section('metadescription', 'Invite your friends from gmail and yahoo to connect with you on ' . config('app.name'))

@section('content')
 
<div class="hero is-medium">
	<div class="hero-body has-text-centered">
		<h3 class="title is-3">Hmmm!, {{$email}} Not Found</h3>
		<p>We couldn't find the your email in our awesome list. We are quite certain you have opted out before.</p>
		<p><a href="{{config('app.url')}}" class="button is-primary">
			<span class="icon"><i class="icon arrow left"></i></span>
			<span>Back to {{config('app.name')}}</span>
		</a></p>
	</div>
</div>


@endsection