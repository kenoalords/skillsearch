@extends('layouts.dashboard')

@section('title', 'Edit Blog' )
@section('content')
<div style="background: #fff; margin-top: 3em">
	<h1 class="title is-3 has-text-centered">Edit: {{ $blog['title'] }}</h1>
	<blog-form blog="{{ json_encode($blog) }}" categories="{{ $categories }}"></blog-form>
</div>
@endsection
