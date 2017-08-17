@extends('layouts.app')

@section('title', 'Edit Blog Post')
@section('content')
<div style="background: #fff; margin-top: 3em">
	<blog-form blog="{{ json_encode($blog) }}" categories="{{ $categories }}" edit="true"></blog-form>
</div>
@endsection
