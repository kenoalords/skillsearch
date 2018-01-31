@extends('layouts.page')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', config('app.name') . ' is a community of skilled people showcasing their awesome talent and getting hired.')
@section('title', 'About')
@section('content')
	
<h1 class="title">About</h1>
<p>
	{{config('app.name')}} is a community of creative people showcasing their awesome works and getting hired.
</p>

<p>
	With the ever increasing demand for creative services in Nigeria, {{config('app.name')}} provides an innovative and interactive online platform to help people showcase their works across various categories and get hired.
</p>

<p>
	{{config('app.name')}} is designed and maintained by <a href="http://clickmedia.com.ng">Clickmedia Solutions</a>
</p>

@if(!Auth::user())
	<a href="/register" class="button is-primary">
		<span>Create a FREE account</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span>
	</a>
@endif
@endsection