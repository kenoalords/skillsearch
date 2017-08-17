@extends('layouts.app')

@section('title', 'Add Blog Post')
@section('content')
<div style="background: #fff; margin-top: 3em">
	<blog-form categories="{{ $categories }}"></blog-form>
</div>
@endsection
