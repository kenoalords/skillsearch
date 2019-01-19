@extends('layouts.dashboard')
@section('title', 'My Blog')
@section('content')

@include('includes.status')
<h1 class="title is-2 bold">Blog</h1>
<h4 class="subtitle">Write about your passion, business, ideas and solutions. Be engaging</h4>
@include('blog.menu')

<div class="notification is-info">
	<strong>PRO TIP:</strong> Blogging is a great way to solidify your position as an industry expert and reach a wider audience. <strong><a href="{{ route('add_blog') }}">click here to start blogging today</a></strong>
</div>

@if($blogs)
	<div class="columns is-multiline">
		@each('blog.partials.blog', $blogs, 'blog')
	</div>
@else
	<p>You have not shared any blog post.</p>
@endif

@endsection
