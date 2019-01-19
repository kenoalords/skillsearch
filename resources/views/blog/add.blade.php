@extends('layouts.dashboard')

@section('title', 'Add a Blog Post')
@section('content')
<div>
	<h1 class="title is has-text-centered">New blog post</h1>
	<blog-form categories="{{ $categories }}"></blog-form>
</div>
@endsection
