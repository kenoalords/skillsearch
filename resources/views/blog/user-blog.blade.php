@extends('layouts.dashboard')
@section('title', 'My Blog')
@section('content')

@include('includes.status')
<h1 class="title is-2 bold is-size-5-mobile">Blog</h1>
<h4 class="subtitle is-size-6-mobile">Write about your passion, business, ideas and solutions. Be engaging</h4>
@include('blog.menu')

<div class="notification is-info">
	<strong>PRO TIP:</strong> Blogging is a great way to solidify your position as an industry expert and reach a wider audience. <strong><a href="{{ route('add_blog') }}">click here to start blogging today</a></strong>
</div>

@if($blogs)
	<div class="columns is-multiline">
		@each('blog.partials.blog', $blogs, 'blog')
	</div>
@else
	<div class="notification is-raised is-white is-padded is-bordered-left">
		<h2 class="title is-1 is-size-3-mobile">✍🏽</h2>
		<h3 class="title is-3 is-size-5-mobile bold">Write your first blog post.</h3>
		<p class="subtitle is-size-6-mobile">Share your passion and creativity with the world.</p>
		<p>
			<a href="{{ route('add_blog') }}" class="button is-info big-action-button is-fullwidth-mobile">Start now</a>
		</p>
	</div>
	<hr style="opacity: .2">
	@include('blog.latest_posts', ['title'=> 'Latest blog post from users'])
@endif

@endsection
