@extends('layouts.page')

@section('thumbnail', asset('public/logo-b.png'))
@section('type', 'article')
@section('metadescription', config('app.name') . ' is a community of skilled people showcasing their awesome talent and getting hired.')
@section('title', 'About')
@section('content')
<div class="content">
	<h1 class="title is-3 bold">Ubanji</h1>
	<h4 class="subtitle is-5 has-text-danger bold">Designed to help you achieve more.</h4>
	<p>
		{{config('app.name')}} is an community focused on helping creative and skilled people in Nigeria showcase their works and explore new opportunities.
	</p>

	<p>
		As a creative people focused platform, {{config('app.name')}} provides an innovative and interactive online tools to help you showcase your works across various categories and be found.
	</p>

	<p>
		If you have any suggestions or enquiries, kindly send us an email at hello[at]ubanji[.]com
	</p>

	<p>
		{{config('app.name')}} is designed and maintained by <a href="http://clickmedia.com.ng" target="_blank">Clickmedia Solutions</a>
	</p>
</div>

@if(!Auth::user())
	<a href="/register" class="button is-primary">
		<span>Create a FREE account</span> <span class="icon"><i class="fa fa-long-arrow-right"></i></span>
	</a>
@endif
@endsection